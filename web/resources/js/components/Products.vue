<template>
    <div>
        <section class="page-search">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <!-- Advance Search -->
                        <div class="advance-search">
                            <form>
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <input type="text" class="form-control" id="inputtext4" placeholder="What are you looking for">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <input type="text" class="form-control" id="inputCategory4" placeholder="Category">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <input type="text" class="form-control" id="inputLocation4" placeholder="Location">
                                    </div>
                                    <div class="form-group col-md-2">

                                        <button type="submit" class="btn btn-primary">Search Now</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="section-sm">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="search-result bg-gray">
                            <h2>Results For "Electronics"</h2>
                            <p>123 Results on 12 December, 2017</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="category-sidebar">
                            <div class="widget category-list">
                                <h4 class="widget-header">All Category</h4>
                                <ul class="category-list">
                                    <li><a href="category.html">Laptops <span>93</span></a></li>
                                    <li><a href="category.html">Iphone <span>233</span></a></li>
                                    <li><a href="category.html">Microsoft  <span>183</span></a></li>
                                    <li><a href="category.html">Monitors <span>343</span></a></li>
                                </ul>
                            </div>

                            <div class="widget category-list">
                                <h4 class="widget-header">Nearby</h4>
                                <ul class="category-list">
                                    <li><a href="category.html">New York <span>93</span></a></li>
                                    <li><a href="category.html">New Jersy <span>233</span></a></li>
                                    <li><a href="category.html">Florida  <span>183</span></a></li>
                                    <li><a href="category.html">California <span>120</span></a></li>
                                    <li><a href="category.html">Texas <span>40</span></a></li>
                                    <li><a href="category.html">Alaska <span>81</span></a></li>
                                </ul>
                            </div>

                            <div class="widget filter">
                                <h4 class="widget-header">Show Produts</h4>
                                <select>
                                    <option>Popularity</option>
                                    <option value="1">Top rated</option>
                                    <option value="2">Lowest Price</option>
                                    <option value="4">Highest Price</option>
                                </select>
                            </div>

                            <div class="widget price-range">
                                <h4 class="widget-header">Price Range</h4>
                                <div class="block">
                                    <b>$10</b>
                                    <input id="ex2" type="text" class="span2" value="" data-slider-min="10" data-slider-max="1000" data-slider-step="5" data-slider-value="[250,450]"/>
                                    <b>$5000</b>
                                </div>
                            </div>

                            <div class="widget product-shorting">
                                <h4 class="widget-header">By Condition</h4>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="checkbox" value="">
                                        Brand New
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="checkbox" value="">
                                        Almost New
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="checkbox" value="">
                                        Gently New
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="checkbox" value="">
                                        Havely New
                                    </label>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="category-search-filter">
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>Short</strong>
                                    <select>
                                        <option>Most Recent</option>
                                        <option value="1">Most Popular</option>
                                        <option value="2">Lowest Price</option>
                                        <option value="4">Highest Price</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <div class="view">
                                        <strong>Views</strong>
                                        <ul class="list-inline view-switcher">
                                            <li class="list-inline-item">
                                                <a href="javascript:void(0);"><i class="fa fa-th-large"></i></a>
                                            </li>
                                            <li class="list-inline-item">
                                                <a href="javascript:void(0);"><i class="fa fa-reorder"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="product-grid-list">
                            <div class="row mt-30">
                                <div v-for="row in aData" class="col-sm-12 col-lg-4 col-md-6">
                                    <!-- product card -->
                                    <div class="product-item bg-light" :key="row.id">
                                        <div class="card">
                                            <div class="thumb-content">
                                                <!-- <div class="price">$200</div> -->
                                                <a href="">
                                                    <img class="card-img-top img-fluid" :src="VUE_URL_ADMIN + 'images/cover-page-default.jpg'" :alt="row.name">
                                                </a>
                                            </div>
                                            <div class="card-body">
                                                <h4 class="card-title"><a href="" v-text="row.name"></a></h4>
                                                <ul class="list-inline product-meta">
                                                    <li class="list-inline-item">
                                                        <a href=""><i class="fa fa-folder-open-o"></i>{{ row.name }}</a>
                                                    </li>
                                                    <li class="list-inline-item">
                                                        <a href=""><i class="fa fa-eye"></i>502</a>
                                                    </li>
                                                </ul>
                                                <p class="card-text" v-text="row.description"></p>
                                                <div class="product-ratings">
                                                    <ul class="list-inline">
                                                        <li class="list-inline-item selected" ><i class="fa fa-star"></i></li>
                                                        <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                                        <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                                        <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                                        <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pagination justify-content-center">
                            <nav aria-label="Page navigation example">
                                <ul class="pagination">
                                    <li class="page-item">
                                        <a class="page-link" href="#" aria-label="Previous">
                                            <span aria-hidden="true">&laquo;</span>
                                            <span class="sr-only">Previous</span>
                                        </a>
                                    </li>
                                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item active"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item">
                                        <a class="page-link" href="#" aria-label="Next">
                                            <span aria-hidden="true">&raquo;</span>
                                            <span class="sr-only">Next</span>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
    export default {
        name: "web-products",
        data(){
            return{
                urlApi: 'api/products/',
                VUE_URL_PROJECT: URL_PROJECT + '/',
                VUE_URL_ADMIN: URL_ADMIN + '/',
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                search: '',
                aData: []
            }
        },
        computed:{
            isActived: function(){
                return this.pagination.current_page;
            },
            //Calcula los elementos de la paginación
            pagesNumber: function() {
                if(!this.pagination.to) {
                    return [];
                }

                var from = this.pagination.current_page - this.offset;
                if(from < 1) {
                    from = 1;
                }

                var to = from + (this.offset * 2);
                if(to >= this.pagination.last_page){
                    to = this.pagination.last_page;
                }

                var pagesArray = [];
                while(from <= to) {
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;

            }
        },
        methods: {
            changePage( page, search ){
                let me = this;
                me.pagination.current_page = page;
                me.listar( page, search );
            },
            list(){
                var me = this;
                var url= me.urlApi + '?search='+ me.search;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.aData = respuesta.records.data;
                    me.pagination= respuesta.pagination;
                }).catch(function (error) {
                    console.log(error);
                });

                // let me = this;
                // me.aData = [
                //     {
                //         'id': 1,
                //         'title': '11inch Macbook Air',
                //         'category': 'Electronics',
                //         'view': 250,
                //         'image': URL_PROJECT + '/dist/images/products/products-1.jpg',
                //         'description': 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Explicabo, aliquam!',
                //         'star': 5
                //     },
                // ]
            }
        },
        mounted() {
            this.list();
        }
    }
</script>

<style scoped>

</style>