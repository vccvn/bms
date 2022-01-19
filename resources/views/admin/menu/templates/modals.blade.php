<!-- end cube-wrapper -->
<div class="modal fade" id="update-item-modal" tabindex="-1" role="dialog" aria-labelledby="custom-modal-name" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form method="POST" action="{{route('admin.menu.item.save')}}" class="menu-item-form update" novalidate>
                @csrf
                <input type="hidden" name="menu_id" value="{{$detail->id}}" class="item-inp">
                <div class="modal-header">
                    <h5 class="modal-title" id="update-item-modal-name">Cập nhật <span id="update-item-title"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="update-item-modal-content">
                        
                        
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                </div>
            </form>
        </div>
    </div>
</div>