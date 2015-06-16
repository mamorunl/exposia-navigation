@if(isset($object['href']) && strlen($object['href']) > 0)
    <a href="{{ $object['href'] }}" title="{{ $object['title'] }}" target="{{ $object['target'] }}">
        <img src="{{ $object['src'] }}" id="{{ $id }}" class="{{ $class }}" alt="{{ $object['alt'] }}">
    </a>
@else
    <img src="{{ $object['src'] }}" id="{{ $id }}" class="{{ $class }}" alt="{{ $object['alt'] }}">
@endif