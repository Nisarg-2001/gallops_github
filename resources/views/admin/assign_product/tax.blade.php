@if(isset($taxData) && !empty($taxData))

@if(isset($data->default_tax) && !empty($data->default_tax))
@php $default_tax = json_decode($data->default_tax); @endphp
@else
@php $default_tax = []; @endphp
@endif



@foreach($default_tax as $t)
@php $default_tax[$t->id] = $t; @endphp
@endforeach



@foreach($taxData as $tax)
<div class="col-12 col-md-4 col-lg-4">
    <div class="form-group">
        <label>{{ $tax->tax_name }} (%)</label>
        <input type="hidden" class="form-control" name="tax_id[]" value="{{ $tax->id }}">
        <input type="hidden" class="form-control" name="tax_name[]" value="{{ $tax->tax_name }}">
        <input type="text" class="form-control" name="tax_value[]" value="{{ !empty($default_tax) && (isset($default_tax[$tax->id])) ? $default_tax[$tax->id]->value : 0 }}" placeholder="0.00">
    </div>
</div>
@endforeach
@endif