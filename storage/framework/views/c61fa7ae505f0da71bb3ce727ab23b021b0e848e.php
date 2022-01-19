
<?php if(isset($article) && $article): ?>
    <?php $__env->startSection('title', $article->getFullTitle()); ?>
    <?php $__env->startSection('meta_title', $article->meta_title?$article->meta_title:$article->getFullTitle()); ?>
    <?php $__env->startSection('description',$article->getShortDesc(255)); ?>
    <?php $__env->startSection('meta_description',$article->meta_description?$article->meta_description:$article->getShortDesc(255)); ?>
    <?php if($article->feature_image): ?>
        <?php $__env->startSection('image',$article->getFeatureImage()); ?>
    <?php endif; ?>
    <?php $__env->startSection('page.type','article'); ?>
    <?php if(isset($category) && $category): ?>
        <?php $__env->startSection('article_section',$category->name?$category->name:$category->title); ?>
    <?php endif; ?>
    <?php $__env->startSection('published_time',$article->dateFormat('Y-m-d').'T'.$article->dateFormat('H:i:s').'+07:00'); ?>
    <?php $__env->startSection('modified_time',$article->updateTimeFormat('Y-m-d').'T'.$article->updateTimeFormat('H:i:s').'+07:00'); ?>
    <?php $__env->startSection('modified_time',$article->updateTimeFormat('Y-m-d').'T'.$article->updateTimeFormat('H:i:s').'+07:00'); ?>

<?php elseif(isset($category)): ?>
    <?php $__env->startSection('title', $category->name); ?>
    <?php if($category->feature_image): ?>
        <?php $__env->startSection('image', $category->getFeatureImage()); ?>
    <?php endif; ?>
    <?php if($category->description): ?>
        <?php $__env->startSection('description', $category->getShortDesc(500)); ?>
    <?php endif; ?>
<?php elseif(isset($page_title)): ?>
    <?php $__env->startSection('title', $page_title); ?>
<?php endif; ?>
