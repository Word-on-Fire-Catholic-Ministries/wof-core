import algoliasearch from 'algoliasearch/lite';
import instantsearch from "instantsearch.js";
import {searchBox, hits, configure, refinementList} from 'instantsearch.js/es/widgets';


const searchpage = (appId, apiKey, index, options = {}) => {

  const _appId = appId
  const _apiKey = apiKey
  const _index = index

  const _options = {
    searchBoxContainer: options.searchBoxContainer ? options.searchBoxContainer : 'searchpage-searchbox',
    hitsContainer: options.hitsContainer ? options.hitsContainer : 'searchpage-hits',
    hitsPerPage: options.hitsPerPage ? options.hitsPerPage : 10,
    catsContainer: options.catsContainer ? options.catsContainer : 'searchpage-cats',
    authorsContainer: options.authorsContainer ? options.authorsContainer : 'searchpage-authors',
    tagsContainer: options.tagsContainer ? options.tagsContainer : 'searchpage-tags',
  }

  const _search = instantsearch({
    indexName: _index,
    searchClient: algoliasearch(_appId, _apiKey),
    searchFunction(helper) {
      // Ensure we only trigger a search when there's a query
      if (helper.state.query) {
        helper.search();
      }
    }
  })

  _search.addWidgets([

    configure({
      hitsPerPage: _options.hitsPerPage,
    }),

    searchBox({
      container: `#${_options.searchBoxContainer}`,
      placeholder: 'Search',
      showReset: false,
      showSubmit: false,
    }),

    refinementList({
      container: `#${_options.catsContainer}`,
      attribute: "categories",
      limit: 5,
      showMore: true,
    }),

    refinementList({
      container: `#${_options.authorsContainer}`,
      attribute: "author.name",
      limit: 5,
      showMore: true,
    }),

    refinementList({
      container: `#${_options.tagsContainer}`,
      attribute: "tags",
      limit: 5,
      showMore: true,
    }),

    hits({
      container: `#${_options.hitsContainer}`,
      templates: {
        item: `
      <article class="searchpage-hit">
          <div class="searchpage-hit-content">
          
          {{#thumbnail}}
          <div class="color-overlay color-overlay-black-fade"></div>
          <img src="{{thumbnail}}" alt="Word on Fire Image">
          {{/thumbnail}}
         
            {{#categories}}
            <p class="searchpage-hit-cats"><span class="searchpage-hit-cat">{{.}}</span></p>
            {{/categories}} 
              <h1 class="searchpage-hit-title">
                  <a href="{{ url }}">
                      {{#helpers.highlight}} 
                          { "attribute": "title", "highlightedTagName": "mark" } 
                      {{/helpers.highlight}}
                  </a>
              </h1>
              <p class="searchpage-hit-author">{{ author.name }}</p>
              
              {{#excerpt}}
              <p class="searchpage-hit-excerpt">{{&excerpt}}</p>
              {{/excerpt}}
          </div>
      </article>
    `,
        empty: `No results for <q>{{ query }}</q>`,
      },
    }),
  ])

  const getUrlParameter = name => {
    name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
    const regex = new RegExp('[\\?&]' + name + '=([^&#]*)')
    const results = regex.exec(location.search);
    return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
  }

  const prefillWithQuery = (searchBoxContainer) => {
    const input = document.querySelector(`#${searchBoxContainer} .ais-SearchBox-input`)

    if (!input) {
      return
    }

    const query = getUrlParameter('s')
    console.log('Searching for: ' + query)

    setTimeout(() => {
      input.value = query
      const evt = new InputEvent('input', {data: query})
      input.dispatchEvent(evt)
    }, 500)
  }

  _search.start()

  prefillWithQuery(_options.searchBoxContainer)

  return {
    search: _search
  }
}

window.wofSearchpage = searchpage
