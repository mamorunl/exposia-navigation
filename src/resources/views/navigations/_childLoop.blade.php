<li id="navigation-item-{{ $node->id }}" class="navigation-item" data-navigationnodeid="{{ $node->id }}" data-id="{{ $index }}" data-name="{{ $node->name }}" data-slug="{{ $node->slug }}">
    <div>
        {{ $node->name }}
        <div class="pull-right">
            @if(count(Config::get('website.languages')) > 0)
                <div class="btn-group">
                    <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        @lang('exposia-navigation::navigations.translations') <i class="fa fa-angle-down"></i>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        @foreach(Config::get('website.languages') as $abbr => $lang)
                            @if($abbr != Config::get('app.locale'))
                                <li><a href="{{ route('admin.translations.edit', [$node->page->id, $abbr]) }}" title="@lang('exposia-navigation::pages.index.edit_language')"><i class="fa fa-language"></i> {{ $lang['name'] }}</a></li>
                            @endif
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