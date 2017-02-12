<?php $thumb = $story->thumb() ?>

<div class="media">
  @if (isset($thumb))
  <div class="media-left">
    <a href="{{ $story->url }}" target="_blank">
      <img class="media-object" src="{{ $thumb->url }}" alt="{{ $thumb->caption }}">
    </a>
  </div>
  @endif
  <div class="media-body">
    <h4 class="media-heading"><a href="{{ $story->url }}" target="_blank">{{ $story->title }}</a></h4>
    {{ $story->abstract }}
  </div>
</div>
