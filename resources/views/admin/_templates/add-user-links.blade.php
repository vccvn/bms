
                                    <div class="input-hidden-users-group d-none" style="diplay:none">
                                        @if($o = old('users'))
                                            @foreach($o as $tid)
                                                <input type="hidden" name="users[]" id="user-hidden-{{$tid}}" class="input-user-hidden" value="{{$tid}}">
                                            @endforeach
                                        @elseif($model->userLinks)
                                            @foreach($model->userLinks as $user)
                                                <input type="hidden" name="users[]" id="user-hidden-{{$user->user_id}}" class="input-user-hidden" value="{{$user->user_id}}">
                                            @endforeach
                                        @endif
                                    </div>
                                    <div class="user-list">
                                        <?php
                                            $users = [];
                                            if($old = old('users')){
                                                $users = get_user_list(['id'=>$old]);
                                            }
                                            elseif ($model->userLinks) {
                                                $users = $model->userLinks;
                                            }
                                            if($users){
                                                $item = $user_templates['link_item'];
                                                $list = $user_templates['link_list'];
                                                $total = count($users);
                                                $items = '';
                                                foreach($users as $t){
                                                    if($t->user_id) $u = $t->user;
                                                    else $u = $t;
                                                    $items.=str_eval($item,['id'=>$u->id,'name'=>$u->name, 'email'=>$u->email, 'username'=>$u->username]);
                                                }
                                                $userlist = str_eval($list,['items'=>$items,'total'=>$total]);
                                                echo $userlist;
                                            }
                                        ?>
                                    </div>
                                    <div class="form-group user-group with-live-search" data-search="#input-user-link">
                                        <div class="input-group" >
                                            <input type="text" name="user" id="input-user-link" class="form-control input-search-user" placeholder="Nhập từ khóa...">
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-primary btn-search-user"><i class="fa fa-search"></i></button>
                                            </span>
                                        </div>
                                        <div class="live-search">
                                            <div class="result d-none">

                                            </div>
                                            <div class="message d-none">
                                                <div id="livw-search-message-text" class="message-text text-center text-info"></div>
                                            </div>
                                            <div class="actions action-menu d-none">
                                                {{-- <a href="#" class="btn-action action-item add-user btn-add-new-users btn btn-primary btn-block">Thêm "<span>user</span>"</a> --}}
                                            </div>
                                        </div>
                                    </div>

