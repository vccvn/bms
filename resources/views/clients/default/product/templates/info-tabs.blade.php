

								<!--Product Info Tabs-->
                                <div class="product-info-tabs">

                                    <!--Product Tabs-->
                                    <div class="prod-tabs" id="product-tabs">

                                        <!--Tab Btns-->
                                        <div class="tab-btns clearfix">
                                            <a href="#prod-description" class="tab-btn active-btn">Chi tiết</a>
                                            {{-- <a href="#prod-reviews" class="tab-btn">Reviews</a> --}}
                                        </div>

                                        <!--Tabs Container-->
                                        <div class="tabs-container">

                                            <!--Tab / Active Tab-->
                                            <div class="tab active-tab" id="prod-description">
                                                <h3>Chi tiết</h3>
                                                <div class="content">
                                                    {!! $product->detail !!}
                                                </div>
                                            </div>

                                            <!--Tab-->
                                            {{-- <div class="tab" id="prod-reviews">
                                                <h3>3 Reviews Found</h3>

                                                <!--Reviews Container-->
                                                <div class="reviews-container">

                                                    <!--Reviews-->
                                                    
                                                    <article class="review-box clearfix">
                                                        <figure class="rev-thumb"><img src="images/resource/author-4.jpg" alt=""></figure>
                                                        <div class="rev-content">
                                                            <div class="rating"><span class="fa fa-star"></span> <span class="fa fa-star"></span> <span class="fa fa-star"></span> <span class="fa fa-star"></span> <span class="fa fa-star"></span></div>
                                                            <div class="rev-info">Sara – March 31, 2016: </div>
                                                            <div class="rev-text"><p>Sed eget turpis a pede tempor malesuada. Vivamus quis mi at leo pulvinar hendrerit. Cum sociis natoque penatibus et magnis dis</p></div>
                                                        </div>
                                                    </article>

                                                </div>

                                                <!--Add Review-->
                                                <div class="add-review">
                                                    <h3>Add a Review</h3>

                                                    <form method="post" action="http://html.tonatheme.com/2018/Corpro_template/shop-single.html">
                                                        <div class="row clearfix">
                                                            <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                                                <label>Name *</label>
                                                                <input type="text" name="name" value="" placeholder="" required>
                                                            </div>
                                                            <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                                                <label>Email *</label>
                                                                <input type="email" name="email" value="" placeholder="" required>
                                                            </div>
                                                            <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                                                <label>Website *</label>
                                                                <input type="text" name="website" value="" placeholder="" required>
                                                            </div>
                                                            <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                                                <label>Rating </label>
                                                                <div class="rating">
                                                                    <a href="#" class="rate-box" title="1 Out of 5"><span class="fa fa-star"></span></a>
                                                                    <a href="#" class="rate-box" title="2 Out of 5"><span class="fa fa-star"></span> <span class="fa fa-star"></span></a>
                                                                    <a href="#" class="rate-box" title="3 Out of 5"><span class="fa fa-star"></span> <span class="fa fa-star"> </span> <span class="fa fa-star"></span></a>
                                                                    <a href="#" class="rate-box" title="4 Out of 5"><span class="fa fa-star"></span> <span class="fa fa-star"></span> <span class="fa fa-star"></span> <span class="fa fa-star"></span></a>
                                                                    <a href="#" class="rate-box" title="5 Out of 5"><span class="fa fa-star"></span> <span class="fa fa-star"></span> <span class="fa fa-star"></span> <span class="fa fa-star"></span> <span class="fa fa-star"></span></a>
                                                                </div>
                                                            </div>
                                                            <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                                                <label>Your Review</label>
                                                                <textarea name="review-message"></textarea>
                                                            </div>
                                                            <div class="form-group text-right col-md-12 col-sm-12 col-xs-12">
                                                                <button type="button" class="theme-btn btn-style-one">Add Review</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>


                                            </div> --}}

                                        </div>
                                    </div>

                                </div>

