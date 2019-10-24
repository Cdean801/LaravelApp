<option>--- Select Date ---</option>
@if(!empty($slots))
  @foreach($slots as $key => $value)
    <option value="{{ $key }}">{{ $value }}</option>
  @endforeach
@endif
