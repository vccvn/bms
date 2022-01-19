<?php
use Cube\Html\Input;

use App\Repositories\Stations\StationRepository;
$trip_time_types = [
    'direct' => [
        1 => 'Xuất bến (đi)',
        2 => 'Vào bến (về)'
    ],
    'indirect' => [
        1 => 'Ghé bến (đi)',
        2 => 'Ghé bến (về)'
    ],
    'bus' => [
        1 => 'Xuất bến',
        2 => 'Vào bến'
    ]
];
?>



<?php $__env->startSection('title','Tra lịch trình'); ?>

<?php $__env->startSection('content'); ?>

        <div class="trip-page">
            <?php echo $__env->make($__templates.'trip-form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <section class="results">
                <div class="container result-data">
                    <?php echo $__env->make($__current.'results', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    
                </div>
            </section>
        </div>
            
<?php $__env->stopSection(); ?>
<?php $__env->startSection('jsinit'); ?>
<script>
    window.tripsInit = function() {
        Cube.trips.init({
            urls:{
                ajax_search:  '<?php echo e(route('client.trip.ajax-search')); ?>',
                ajax_detail:  '<?php echo e(route('client.trip.detail')); ?>'
            }
        });
    };
</script>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
<?php echo $__env->make($__utils.'datetime', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<script src="<?php echo e(asset('js/client/trips.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make($__layouts.'single', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>