{{-- neu co bai viet hoac san pham dc khai bao --}}
@if(isset($article) && $article)
    @section('title', $article->getFullTitle())
    @section('meta_title', $article->meta_title?$article->meta_title:$article->getFullTitle())
    @section('description',$article->getShortDesc(255))
    @section('meta_description',$article->meta_description?$article->meta_description:$article->getShortDesc(255))
    @if($article->feature_image)
        @section('image',$article->getFeatureImage())
    @endif
    @section('page.type','article')
    @if(isset($category) && $category)
        @section('article_section',$category->name?$category->name:$category->title)
    @endif
    @section('published_time',$article->dateFormat('Y-m-d').'T'.$article->dateFormat('H:i:s').'+07:00')
    @section('modified_time',$article->updateTimeFormat('Y-m-d').'T'.$article->updateTimeFormat('H:i:s').'+07:00')
    @section('modified_time',$article->updateTimeFormat('Y-m-d').'T'.$article->updateTimeFormat('H:i:s').'+07:00')

@elseif(isset($category))
    @section('title', $category->name)
    @if($category->feature_image)
        @section('image', $category->getFeatureImage())
    @endif
    @if($category->description)
        @section('description', $category->getShortDesc(500))
    @endif
@elseif(isset($page_title))
    @section('title', $page_title)
@endif
