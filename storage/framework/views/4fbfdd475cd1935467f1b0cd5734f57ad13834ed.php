                    <?php if(in_array('advance', $required_fields)): ?>
                        <!-- link -->
                        <div class="card sameheight-item">

                            
                            <div class="product-links">
                                <!-- Nav tabs -->
                                <div class="card-title-block">
                                    <h3 class="title"> Mở rộng </h3>
                                </div>
                                <ul class="nav nav-tabs nav-tabs-bordered">
                                    <?php if($t): ?>
                                    <li class="nav-item">
                                        <a href="#tag-link" class="nav-link active" data-target="#tag-link" data-toggle="tab" aria-controls="product-linked" role="tab">Thẻ</a>
                                    </li>
                                    <?php endif; ?>
                                    <?php if($hasProductLink): ?>
                                        <li class="nav-item">
                                            <a href="#product-linked" class="nav-link <?php echo e(!$t?'active':''); ?>" data-target="#product-linked" data-toggle="tab" aria-controls="product-linked" role="tab">
                                                Sản phẩm
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#search-product-list" class="nav-link" data-target="#search-product-list" aria-controls="search-product-list" data-toggle="tab" role="tab">Thêm sản phẩm</a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                                <!-- Tab panes -->
                                <div class="tab-content tabs-bordered pb-3">
                                    <?php if($t): ?>
                                    <div class="tab-pane fade in active show" id="tag-link">
                                        <h5>Thẻ</h5>
                                        <?php echo $__env->make($__templates.'add-tags-feature', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                    </div>
                                    <?php endif; ?>

                                    <?php if($hasProductLink): ?>
                                        <div class="tab-pane fade in <?php echo e(!$t?'active show':''); ?>" id="product-linked">
                                            <h5>Các sản phẩm đã liên kết</h5>
                                            <div class="list-product-linked">
                                                <?php
                                                    if($prods = $model->getProductLinked()){
                                                        $item = $templates['linked_item'];
                                                        $list = $templates['linked_list'];
                                                        $total = count($prods);
                                                        $items = '';
                                                        foreach($prods as $p){
                                                            $items.=str_eval($item,['id'=>$p->id,'name'=>$p->name]);
                                                        }
                                                        $linked = str_eval($list,['links'=>$items,'total'=>$total]);
                                                        echo $linked;
                                                    }else{
                                                        echo str_eval($templates['message'],['message'=>"Chưa có sản phẩm nào dc liên kết"]);
                                                    }
                                                ?>
                                            </div>

                                        </div>
                                        <div class="tab-pane fade" id="search-product-list">
                                            <h5>Thêm sản phẩm</h5>
                                            <div class="form-group">
                                                <?php echo $inputs->product_cate_id; ?>

                                            </div>
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <input type="search" name="search" class="form-control" id="product-live-search-input" placeholder="Nhập từ khóa hoặc tên sản phẩm">
                                                    <div class="input-group-btn">
                                                        <button type="button" class="btn btn-primary" id="btn-search-product"><i class="fa fa-search"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="search-results"></div>
                                        </div>
                                    <?php endif; ?>


                                </div>
                            </div>
                            <!-- /.card-block -->
                        </div>
                        <!-- /.card -->
                        
                        <?php endif; ?>