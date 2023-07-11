@foreach ($post_penyakit as $item)
    <!-- Modal -->
    <div class="modal fade" id="showModal{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLabel">{{ $item->title_post_penyakit }} -
                        {{ $item->penyakit->nama_penyakit }}</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col-md-12 w-full">
                        <div class="card">
                            <img src="{{ Storage::url($item->image_post_penyakit) }}" class="card-img-top"
                                alt="{{ $item->id }}">
                            <div class="card-body">
                                <h5 class="card-title my-3">{{ $item->title_post_penyakit }}</h5>
                                <p class="card-text my-3">{!! $item->description_post_penyakit !!}</p>
                                <div class="ratio ratio-16x9 my-2">
                                    <iframe src="{{ $item->video_post_penyakit }}" class="rounded"
                                        title="YouTube video {{ $item->title_post_penyakit }}" allowfullscreen></iframe>
                                </div>
                                <p class="card-text my-2">Tags:
                                    @php
                                        $tags = json_decode($item->tags_post_penyakit, true);
                                    @endphp

                                    @if (is_array($tags))
                                        @foreach ($tags as $tag)
                                            <span class="badge bg-primary">{{ $tag['value'] }}</span>
                                        @endforeach
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endforeach
