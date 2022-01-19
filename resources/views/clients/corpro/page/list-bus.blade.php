
@extends($__layouts.'main2')
@section('content')
 <section style="margin-top: 50px">
            <div class="container-fluid" style="bottom: 0px">
                    <div class="container header-filter " >
                        <div class="col-md-12 p-0">
                            <div class="main-filter p-4">
                                <h3 class="pb-2">
                                    <span class="text-bold text-white pl-3">Tìm vé xe</span>
                                </h3>
                                <form action="./list-buses.html">
                                    <div class="col-md-12 row">
                                        <div class="col-md-3">
                                            <div class="form-group d-unset">
                                                <label for="to" class="text-white">Điểm đi</label>
                                                <select class="form-control" disabled>
                                                    <option value="" selected="selected">Bến xe T4D</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group d-unset">
                                                <label for="from" class="text-white">Điểm đến</label>
                                                <select class="form-control">
                                                    <option value="">Bến xe Tuyên Quang</option>
                                                    <option value="">Bến xe Hòa Bình</option>
                                                    <option value="">Bến xe Cà Mau</option>
                                                    <option value="">Bến xe Hồ Chí Minh</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group d-unset">
                                                <label for="from" class="text-white">Ngày đi</label>
                                                <select class="form-control">
                                                    <option value="">19/10/2018</option>
                                                    <option value="">19/10/2018</option>
                                                    <option value="">19/10/2018</option>
                                                    <option value="">19/10/2018</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3 text-center align-items-end d-gird">
                                            <div class="form-group d-unset mb-0">
                                                <button type="submit" class="btn">Tìm kiếm</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
        </section>
        <section>
            <div class="container">
                <div class="about-us row">
                    <table class="table">
                        <tr>
                            <th>#</th>
                            <th width="220px">Tuyến xe</th>
                            <th>Lộ trình</th>
                            <th width="230px">Thời gian bắt đầu</th>
                            <th width="230px">Thời gian kết thúc</th>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Hà Nội --> Thanh Hóa</td>
                            <td>Mỹ Đình, Nghi Sơn, Còng, Quốc lộ 1A, Nông Cống</td>
                            <td>04:30</td>
                            <td>04:30</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Hà Nội --> Điện Biên</td>
                            <td>Mỹ Đình, Chăm Mát, Sơn La, Tuần Giáo, Điện Biên </td>
                            <td>06:00</td>
                            <td>18:00</td>
                        </tr>
                         <tr>
                            <td>2</td>
                            <td>Hà Nội --> Lạng Sơn</td>
                            <td>Mỹ Đình, Cao Bằng, Vĩnh Yên ,Lạng Sơn </td>
                            <td>04:30</td>
                            <td>04:30</td>
                        </tr>
                    </table>    
                </div>
            </div>
        </section>>
@endsection