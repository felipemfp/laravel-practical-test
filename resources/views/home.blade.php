@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                  <div id="btnLoad" class="btn btn-default pull-right">
                    Update stories
                  </div>
                  <h4>Saved Stories</h4>
                </div>

                <div class="panel-body">
                    @if (count($stories) > 0)
                      <div class="media-list">
                        @each('components.story', $stories, 'story')
                      </div>
                    @else
                      There's no saved stories.
                    @endif
                </div>
                <div class="panel-footer">
                  Data provided by <a href="http://developer.nytimes.com" target="_blank">The New York Times</a>.
                </div>
            </div>
            @if (count($stories) > 0)
              {{ $stories->links() }}
            @endif
        </div>
    </div>
</div>
@endsection
