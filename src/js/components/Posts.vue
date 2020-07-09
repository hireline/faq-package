<template>
    <ais-instant-search :search-client="searchClient" index-name="faq_posts">
    <div class="row">
        <div class="col s2 right-align" style="width:20%">
            <p class="" style="font-size:1.45rem; margin: 1.5rem 0 0 0; font-weight:100;">
                Estamos aquí para ayudarte
            </p>
        </div>
        <div class="col s7" style="width:60%;">
            <ais-search-box>
                <div slot-scope="{ currentRefinement, refine }">
                    <div class="input-field search">
                        <span id="search" class="material-icons">search</span>
                        <input 
                            id="query" 
                            type="search" 
                            name="q" 
                            placeholder="Busca respuestas..." 
                            autocomplete="off" 
                            autofocus 
                            style="height:4rem;"
                            :value="currentRefinement"
                            :model="currentRefinement"
                            @input="refine($event.currentTarget.value)"
                        >
                        <span
                            v-show="currentRefinement != ''"
                            class="material-icons"
                            title="Limpiar búsqueda"
                            style="top: 15px; color: black;"
                            @click="refine()"
                        >
                            clear
                        </span>
                    </div>
                </div>
            </ais-search-box>  
        </div>
    </div>
        <div class="container" style="width: 60%;">
	        <div class="row">
                <div class="col s12">
			        <div class="card-panel">
                        <ais-state-results>
                        <div slot-scope="{ hits }">
                            <ais-hits v-if="hits.length > 0">
                                <table class="highlight" slot="item" slot-scope="{ item }">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <a :href="item.url">
                                                    <ul>
                                                        <li>
                                                            <p class="post-title">{{ item.title }}</p>
                                                        </li>
                                                    </ul>   
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </ais-hits>
                            <div v-else>
                                <h2>No hubo resultados para la búsqueda</h2>
                            </div>
                        </div>
                        </ais-state-results>
			        </div>
                </div>
	        </div>
        </div>
        <ais-configure :query="initialQuery" :facet-filters="roles"/>
    </ais-instant-search>
</template>

<script>
    import algoliasearch from 'algoliasearch/lite';
    export default {
        props: ['initial-query', 'roles', 'algolia-id', 'algolia-search'],
        data() {
            return {
                searchClient: algoliasearch(
                    this.algoliaId,
                    this.algoliaSearch
                )
            };
        },
        mounted() {
        }
    }
</script>

<style>
    ol.ais-Hits-list {
        list-style-type: none;
        padding-inline-start: 0;
    }
    td {
        padding: 15px;
    }
    tr {
        -webkit-transition: background-color .25s ease;
        transition: background-color .25s ease;
    }
    .post-title {
        color: #00abc6;
        font-size: 1.3rem;
        margin-block-start: 0em;
    }
</style>