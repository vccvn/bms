@extends($__layouts.'main')

@section('title', 'Phân quyền')

@section('content')


<?php
$roles = [];
?>

<article class="content items-list-page">
            
    <!-- list header -->
    <div class="title-search-block">
        <div class="title-block">
            <div class="row">
                <div class="col-md-6">
                    <h3 class="title"> Quyền
                        {{-- <a href="{{route('admin.permission.add')}}" class="btn btn-primary btn-sm rounded-s"> Thêm mới </a> --}}
                    </h3>
                    
                </div>
            </div>
        </div>
        @include($__templates.'list-search',['search_route'=>'admin.permission.list'])
    </div>
    <!-- list content -->
    <div class="card">
        <div class="card-block">
            <div class="card-title-block">
                <h3 class="title"> Danh sách Quyền </h3>
            </div>
            <section class="card-body">
                @if($list->count()>0)
                <div class="">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                {{-- <th>
                                    <label class="d-block">
                                        <input type="checkbox" name="check_all" class="check-all checkbox">
                                        <span></span>
                                    </label>
                                </th> --}}
                                <th>ID</th>
                                <th>Tên</th>
                                <th>Người dùng</th>
                                <th>Module</th>
                                {{-- <th class="text-right">
                                
                                </th> --}}
                                
                            </tr>
                        </thead>
                        <tbody class="list-body list-role">
                        @foreach($list as $item)
                        <?php 
                        $roles['role_'.$item->id] = [
                            'id' => $item->id,
                            'name' => $item->name,
                            'users' => [
                                'inrole' => [
                                    'list' => [],
                                    'search' => '',
                                    'page' => 1,
                                    'total' => $item->users()->count()
                                ],
                                'notinrole' => [
                                    'list' => [],
                                    'search' => '',
                                    'page' => 1,
                                    'total' => $item->usersNotIn()->count()
                                ]
                                
                            ],
                            'modules' => [
                                 'required' => [
                                    'list' => [],
                                    'search' => '',
                                    'page' => 1,
                                    'total' => $item->modules()->count()
                                ],
                                'notrequired' => [
                                    'list' => [],
                                    'search' => '',
                                    'page' => 1,
                                    'total' => $item->modulesNotRequired()->count()
                                ]
                            ]
                            
                        ];
                        ?>
                            <tr id="role-item-{{$item->id}}">
                                {{-- <th>
                                    <label class="d-block">
                                        <input type="checkbox" name="roles[{{$loop->index}}][id]" class="check-item checkbox" value="{{$item->id}}">
                                        <span></span>
                                    </label>
                                </th> --}}
                                <th scope="row">{{$item->id}}</th>
                                <td>
                                    <a href="#">{{$item->name}}</a>
                                </td>
                                <td>
                                    <a href="#" class="btn btn-primary btn-view-user-has-role btn-sm" data-id="{{$item->id}}"><i class="fa fa-user"></i></a>
                                </td>
                                <td>
                                    <a href="#" class="btn btn-warning btn-view-module-require-role btn-sm" data-id="{{$item->id}}"><i class="fa fa-folder"></i></a>
                                </td>
                                {{-- <td class="text-right">
                                    <span class="d-block text-right">
                                        <a href="{{$item->getUpdateUrl()}}" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i></a>
                                        <a href="#" class="btn btn-danger btn-sm btn-delete-role" data-id="{{$item->id}}"><i class="fa fa-trash"></i></a>
                                    </span>
                                </td> --}}
                            </tr>
                        @endforeach
                        </tbody>

                    </table>
                    <div class="row pt-4">
                        <div class="col-12 col-md-6">
                            {{-- <a href="#" class="btn btn-sm btn-primary btn-check-all"><i class="fa fa-check"></i></a>
                            <a href="#" class="btn btn-sm btn-danger btn-delete-all-role"><i class="fa fa-trash"></i></a> --}}
                            
                        </div>
                        <div class="col-12 col-md-6">
                            <nav aria-label="Page navigation example" class="text-right">
                                {{$list->links('vendor.pagination.custom')}}
                            </nav>
                        </div>
                    </div>
                </div>
                @endif
            </section>
        </div>
    </div>


</article>

@endsection


@section('jsinit')
<script>
    window.permissionsInit = function() {
        Cube.permissions.init({
            roles:{!! json_encode($roles) !!},
            urls:{
                get_list_user_in_role               : '{{route('admin.permission.get-users-in-role')}}',
                get_list_user_not_in_role           : '{{route('admin.permission.get-users-not-in-role')}}',
                get_list_module_required_role       : '{{route('admin.permission.get-modules-required-role')}}',
                get_list_module_not_required_role   : '{{route('admin.permission.get-modules-not-required-role')}}',
                add_users_role                      : '{{route('admin.permission.add-users-role')}}',
                remove_users_role                   : '{{route('admin.permission.remove-users-role')}}',
                add_modules_role                    : '{{route('admin.permission.add-modules-role')}}',
                remove_modules_role                 : '{{route('admin.permission.remove-modules-role')}}',
                delete_role_url                     : '{{route('admin.permission.delete')}}'
            }
        });
    };
</script>
@endsection

@section('css')
<link rel="stylesheet" href="{{asset('css/roles.css')}}">
@endsection


@section('modal')
    @include('admin.role.modal')
@endsection

