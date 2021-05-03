<option value="">--- Pilih Spesifikas ---</option>
@if(!empty($jenis))
  @foreach($jenis as $key => $value)
    <option value="{{ $key }}">{{ $value }}</option>
  @endforeach
@endif