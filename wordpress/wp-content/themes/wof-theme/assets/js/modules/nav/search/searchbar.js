import algoliasearch from 'algoliasearch/lite';
import instantsearch from "instantsearch.js";
import { searchBox, hits, configure } from 'instantsearch.js/es/widgets';


const searchbar = (appId, apiKey, index, options = {}) => {

  const _appId = appId
  const _apiKey = apiKey
  const _index = index

  const _options = {
    searchBoxContainer: options.searchBoxContainer ? options.searchBoxContainer : 'searchbar-searchbox',
    hitsContainer: options.hitsContainer ? options.hitsContainer : 'searchbar-hits',
    resultsText: options.resultsText ? options.resultsText : 'See all results',
    resultsCss: options.resultsCss ? options.resultsCss : 'searchbar-hits-results',
    resultsId: options.resultsId ? options.resultsId : 'searchbar-hits-results',
    hitsPerPage: options.hitsPerPage ? options.hitsPerPage : 3,
    clearBtn: options.clearBtn ? options.clearBtn : 'searchbar-clear-btn',
    submitBtn: options.submitBtn ? options.submitBtn : 'searchbar-submit-btn',
    openBtn: options.openBtn ? options.openBtn : 'searchbar-open-btn',
    searchbar: options.searchbar ? options.searchbar : 'main-searchbar',
  }

  const renderResultsLink = (hitsContainer, query) => {

    const hits =  document.getElementById(hitsContainer)

    if (!hits) {
      return null
    }

    let results = document.getElementById(_options.resultsId)

    if (!results) {
      const link = document.createElement("a")
      link.setAttribute('id', _options.resultsId)
      link.setAttribute('class', _options.resultsCss)
      const linkText = document.createTextNode(_options.resultsText)
      link.appendChild(linkText)
      hits.appendChild(link)
      results = link
    }

    if (hits.lastChild !== results) {
      hits.removeChild(results)
      hits.appendChild(results)
    }

    results.setAttribute('href', encodeURI(`?s=${query}`))
  }

  const _search = instantsearch({
    indexName: _index,
    searchClient: algoliasearch(_appId, _apiKey ),
    searchFunction(helper) {
      // Ensure we only trigger a search when there's a query
      if (helper.state.query) {
        helper.search();
        renderResultsLink( _options.hitsContainer, helper.state.query)
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

    hits({
      container: `#${_options.hitsContainer}`,
      templates: {
        item: `
      <article class="searchbar-hit">
          <div class="color-overlay color-overlay-black-fade"></div>
          <img class="searchbar-hit-img" src="{{ thumbnail }}" alt="Test">
          <div class="searchbar-hit-content">
          
            {{#categories}}
            <p class="searchbar-hit-cats"><span class="searchbar-hit-cat">{{.}}</span></p>
            {{/categories}} 
              
              <h1 class="searchbar-hit-title">
                  <a href="{{ url }}">
                      {{#helpers.highlight}} 
                          { "attribute": "title", "highlightedTagName": "mark" } 
                      {{/helpers.highlight}}
                  </a>
              </h1>
              <p class="searchbar-hit-author">{{ author.name }}</p>
          </div>
      </article>
    `,
        empty: `No results for <q>{{ query }}</q>`,
      },
    }),
  ])

  _search.start()

  const clearSearch = (searchBoxContainer) => {
    const input = document.querySelector(`#${searchBoxContainer} .ais-SearchBox-input`)

    if (!input) {
      return
    }

    input.value = ''
  }

  const clearHits = (hitsContainer) => {
    const hits = document.getElementById(hitsContainer)

    if (!hits) {
      return
    }

    while (hits.firstChild) {
      hits.removeChild(hits.lastChild)
    }
  }

  const attachOpenBtn = (searchbar, openbtn, searchBoxContainer) => {
    const bar = document.getElementById(searchbar)
    const open = document.getElementById(openbtn)
    const input = document.querySelector(`#${searchBoxContainer} .ais-SearchBox-input`)

    if (!bar || !open) {
      return
    }

    open.addEventListener('click', event => {
      bar.classList.add('search-open')

      if (input) {
        input.focus()
        input.select()
      }
    })
  }

  const attachCloseBtn = (searchbar, closebtn, searchBoxContainer, hitsContainer) => {
    const bar = document.getElementById(searchbar)
    const close = document.getElementById(closebtn)

    if (!bar || !close) {
      return
    }

    close.addEventListener('click', event => {
        bar.classList.remove('search-open')
        clearSearch(searchBoxContainer)
        clearHits(hitsContainer)
      })
    }

  attachOpenBtn(_options.searchbar, _options.openBtn, _options.searchBoxContainer)
  attachCloseBtn(_options.searchbar, _options.clearBtn, _options.searchBoxContainer, _options.hitsContainer)

  return {
    search: _search
  }

}

window.wofSearchbar = searchbar