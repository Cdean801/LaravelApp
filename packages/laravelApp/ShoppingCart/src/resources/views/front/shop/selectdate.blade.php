<option>--- Select Date ---</option>
@if(!empty($dates))
  @foreach($dates as $key => $value)
    <option value="{{ $key }}">{{ $value }}</option>
  @endforeach
@endif
