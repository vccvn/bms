
                    
                    <div class="input-hidden-tag-group d-none" style="diplay:none">
                        @if($o = old('tags'))
                            @foreach($o as $tid)
                                <input type="hidden" name="tags[]" id="tag-hidden-{{$tid}}" class="input-tag-hidden" value="{{$tid}}">
                            @endforeach
                        @elseif($model->tagLinks)
                            @foreach($model->tagLinks as $tag)
                                <input type="hidden" name="tags[]" id="tag-hidden-{{$tag->tag_id}}" class="input-tag-hidden" value="{{$tag->tag_id}}">
                            @endforeach
                        @endif
                    </div>

