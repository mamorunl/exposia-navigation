<li id="navigation-item-{{ $node->id }}" class="navigation-item" data-navigationnodeid="{{ $node->id }}" data-id="{{ $index }}" data-name="{{ $node->name }}" data-slug="{{ $node->slug }}">
    <div>
        {{ $node->name }}
        <div class="pull-right">
            @if(count(Config::get('cms.translations')) > 0)
                <div class="btn-group">
                    <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        @lang('exposia-navigation::navigations.translations') <i class="fa fa-angle-down"></i>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        @foreach(Config::get('cms.translations') as $language_code => $language_array)
                            <li>
                                <a href="{{ route('admin.translations.edit', [$node->id, $language_code, $nav->id]) }}">{{ $language_array['name'] }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if($node->page != null)
                <a href="{{ route('admin.pages.edit', $node->page->id) }}" class="btn btn-default btn-xs">
                    @lang('exposia::global.edit')
                </a>
            @endif
            <a href="#" class="remove-navigation-node btn btn-danger btn-xs">@lang('exposia::global.destroy')</a>
        </div>
    </div>
    <ol>
        @if(count($node->children($nav->id)) > 0)
            @foreach($node->getChildren($nav->id) as $child)
                @include('exposia-navigation::navigations._childLoop', ['node' => $child])
            @endforeach
        @endif
    </ol>
</li>