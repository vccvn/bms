
@if($projects && count($prjs = $projects->getChildren(['@order_by'=>['created_at'=>'DESC'], '@limit'=>6])))
<?php
    $project_tags = [];

    $pj_tpl = '

                    <div class="default-portfolio-item {$tags} col-md-4 col-sm-6 col-xs-12">
                        <div class="inner hover-style1">
                            <figure class="hover-style1-img">
                                <img src="{$image}" alt="image">
                                <div class="hover-style1-view">
                                    <a class="lightbox-image option-btn" title="Image Caption Here" data-fancybox-group="example-gallery" href="{$image}">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                </div>
                            </figure>
                            <div class="hover-style1-title title-style-1">
                                <h3><a href="{$url}">{$title}</a></h3>
                                <span>{$client_name}</span>
                            </div>
                        </div>
                    </div>
    
    ';
    $lst_tpl = '';
    foreach ($prjs as $project) {
        $ts = [];
        if($tags = $project->getTags()){
            foreach ($tags as $tag) {
                $ts[] = $tag->tagname;
                $project_tags[$tag->tagname] = $tag->keywords;
            }
        }
        $project->applyMeta();
        $data = [
            'tags' =>implode(' ', $ts),
            'title' => $project->title,
            'url' => $project->getViewUrl(),
            'image' => $project->getFeatureImage(),
            'client_name' => $project->client_name
        ];
        $lst_tpl .= str_eval($pj_tpl, $data);
    }
?>
        <section class="projects gray_bg">
            <div class="auto-container">
                <div class="sec-title center">
                    <h2>Các dự án <span class="theme_color">Light Solution</span></h2>
                    <span class="separator"></span>
                </div>
                <ul class="post-filter text-center list-inline">
                    <li class="active" data-filter=".default-portfolio-item">
                        <span>Tất cả</span>
                    </li>
                    @foreach($project_tags as $tagname => $keywords)
                    
                    <li data-filter=".{{$tagname}}">
                        <span>{{$keywords}}</span>
                    </li>

                    @endforeach
                </ul>
                <div class="row clearfix masonary-layout filter-layout">
 
                    {!! $lst_tpl !!}

                </div>
            </div>
        </section>
        
@endif