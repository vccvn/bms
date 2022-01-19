

@if($tags)
                                <div class="pull-left tags"><strong>Thẻ :</strong> 
                                    @foreach($tags as $tag)
                                        <a href="{{route('client.search',['s'=>$tag->keywords])}}">{{$tag->keywords}} </a>
                                    @endforeach
                                </div>
                                
@endif