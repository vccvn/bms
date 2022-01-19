<div class="props-block mt-2">
    <h4>Thuộc tính</h4>
    @if($pps = $model->getParentProps())
        <div class="parent-props">
            <span>Được kế thừa: </span>
            @foreach($pps as $p)
                {{$loop->index > 0? ', ':''}}
                {{"$p->name($p->label): $p->type"}}
            @endforeach
        </div>
    @endif

    <div class="props-table">
        <div class="table-header d-none d-md-block">
            <div class="row">
                <div class="col-sm-6 col-md-3">
                    Tên thuộc tính
                </div>
                <div class="col-sm-6 col-md-3">
                    Nhãn
                </div>
                <div class="col-sm-6 col-md-3">
                    Kiểu
                </div>
                <div class="col-sm-6 col-md-3">
                    Mặc định
                </div>
            </div>
        </div>
        <div class="table-body" id="cate-prop-list">
            @if($props = old('props'))
            @foreach($props as $p)
            <div id="prop-{{$loop->index}}" class="row cate-props">
                <div class="col-sm-6 col-md-3 col-prop-name">
                    <input type="text" name="props[{{$loop->index}}][name]" id="prop-{{$loop->index}}-name" class="form-control" placeholder="Tên. vd: color">
                </div>
                <div class="col-sm-6 col-md-3 col-prop-label">
                    <input type="text" name="props[{{$loop->index}}][label]" id="prop-{{$loop->index}}-label" class="form-control" placeholder="Nhãn. vd: màu sắc">
                </div>
                <div class="col-sm-6 col-md-3 col-prop-type">
                    <select name="props[{{$loop->index}}][type]" id="prop-{{$loop->index}}-type" class="form-control">
                        <option value="text">text</option>
                        <option value="number">Số</option>
                        <option value="list">Danh sách</option>
                        
                    </select>
                </div>
                <div class="col-sm-6 col-md-3 col-prop-defval">
                    <input type="text" name="props[{{$loop->index}}][defval]" id="prop-{{$loop->index}}-defval" class="form-control" placeholder="Ví dụ: vàng, xanh">
                </div>
            </div>
            @endforeach
            @endif
        </div>
    </div>
</div>