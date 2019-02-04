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
                                                    <img class="card-img-top img-fluid" :src="row.image" :alt="row.title">
                                                </a>
                                            </div>
                                            <div class="card-body">
                                                <h4 class="card-title"><a href="" v-text="row.title"></a></h4>
                                                <ul class="list-inline product-meta">
                                                    <li class="list-inline-item">
                                                        <a href=""><i class="fa fa-folder-open-o"></i>{{ row.category }}</a>
                                                    </li>
                                                    <li class="list-inline-item">
                                                        <a href=""><i class="fa fa-eye"></i>{{ row.view }}</a>
                                                    </li>
                                                </ul>
                                                <p class="card-text" v-text="row.description"></p>
                                                <div class="product-ratings">
                                                    <ul class="list-inline">
                                                        <li class="list-inline-item" :class="[row.star >= 1 ? 'selected' : '']" ><i class="fa fa-star"></i></li>
                                                        <li class="list-inline-item" :class="[row.star >= 2 ? 'selected' : '']"><i class="fa fa-star"></i></li>
                                                        <li class="list-inline-item" :class="[row.star >= 3 ? 'selected' : '']"><i class="fa fa-star"></i></li>
                                                        <li class="list-inline-item" :class="[row.star >= 4 ? 'selected' : '']"><i class="fa fa-star"></i></li>
                                                        <li class="list-inline-item" :class="[row.star >= 5 ? 'selected' : '']"><i class="fa fa-star"></i></li>
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
                aData: []
            }
        },
        methods: {
            list(){
                let me = this;
                me.aData = [
                    {
                        'id': 1,
                        'title': '11inch Macbook Air',
                        'category': 'Electronics',
                        'view': 250,
                        'image': URL_PROJECT + '/dist/images/products/products-1.jpg',
                        'description': 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Explicabo, aliquam!',
                        'star': 5
                    },
                    {
                        'id': 2,
                        'title': 'Study Table Combo',
                        'category': 'Furnitures',
                        'view': 250,
                        'image': URL_PROJECT + '/dist/images/products/products-2.jpg',
                        'description': 'Lorem ipsum d/olor sit amet, consectetur adipisicing elit. Explicabo, aliquam!',
                        'star': 3
                    },
                    {
                        'id': 3,
                        'title': '11inch Macbook Air',
                        'category': 'Electronics',
                        'view': 250,
                        'image': URL_PROJECT + '/dist/images/products/products-3.jpg',
                        'description': 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Explicabo, aliquam!',
                        'star': 2
                    },
                    {
                        'id': 4,
                        'title': '11inch Macbook Air',
                        'category': 'Electronics',
                        'view': 250,
                        'image': URL_PROJECT + '/dist/images/products/products-1.jpg',
                        'description': 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Explicabo, aliquam!',
                        'star': 5
                    },
                    {
                        'id': 5,
                        'title': 'Study Table Combo',
                        'category': 'Furnitures',
                        'view': 250,
                        'image': URL_PROJECT + '/dist/images/products/products-2.jpg',
                        'description': 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Explicabo, aliquam!',
                        'star': 3
                    },
                    {
                        'id': 6,
                        'title': '11inch Macbook Air',
                        'category': 'Electronics',
                        'view': 250,
                        'image': URL_PROJECT + '/dist/images/products/products-3.jpg',
                        'description': 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Explicabo, aliquam!',
                        'star': 2
                    },
                    {
                        'id': 7,
                        'title': '11inch Macbook Air',
                        'category': 'Electronics',
                        'view': 250,
                        'image': URL_PROJECT + '/dist/images/products/products-1.jpg',
                        'description': 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Explicabo, aliquam!',
                        'star': 5
                    },
                    {
                        'id': 8,
                        'title': 'Study Table Combo',
                        'category': 'Furnitures',
                        'view': 250,
                        'image': URL_PROJECT + '/dist/images/products/products-2.jpg',
                        'description': 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Explicabo, aliquam!',
                        'star': 4
                    },
                    {
                        'id': 9,
                        'title': '11inch Macbook Air',
                        'category': 'Electronics',
                        'view': 250,
                        'image': URL_PROJECT + '/dist/images/products/products-3.jpg',
                        'description': 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Explicabo, aliquam!',
                        'star': 2
                    },
                    {
                        'id': 10,
                        'title': '11inch Macbook Air',
                        'category': 'Electronics',
                        'view': 250,
                        'image': URL_PROJECT + '/dist/images/products/products-1.jpg',
                        'description': 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Explicabo, aliquam!',
                        'star': 5
                    },
                    {
                        'id': 11,
                        'title': 'Study Table Combo',
                        'category': 'Furnitures',
                        'view': 250,
                        'image': URL_PROJECT + '/dist/images/products/products-2.jpg',
                        'description': 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Explicabo, aliquam!',
                        'star': 3
                    },
                    {
                        'id': 12,
                        'title': '11inch Macbook Air',
                        'category': 'Electronics',
                        'view': 250,
                        'image': URL_PROJECT + '/dist/images/products/products-3.jpg',
                        'description': 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Explicabo, aliquam!',
                        'star': 2
                    }
                ]
            }
        },
        mounted() {
            this.list();
        }
    }
</script>

<style scoped>

</style>