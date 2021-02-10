<?php

defined( 'ABSPATH' ) || exit;

get_header();
?>
<main id="site-content" role="main" class="search" style="padding-top: 150px">

    <div class="searchpage-inner">
        <h1 class="searchpage-title">SEARCH RESULTS</h1>
        <section class="searchpage">
            <div id="searchpage-searchbox"></div>
            <aside class="searchpage-filters">
               <h2>Refine results</h2>
                <div class="results-title">Categories</div>
                <div id="searchpage-cats"></div>
                <div class="results-title">Authors</div>
                <div id="searchpage-authors"></div>
                <div class="results-title">Tags</div>
                <div id="searchpage-tags"></div>
            </aside>
            <div class="searchpage-results">

                <div id="searchpage-hits"></div>
            </div>
        </section>
    </div>
</main>
<?php
get_footer();