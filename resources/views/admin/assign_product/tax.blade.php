@if(isset($taxData) && !empty($taxData))

@foreach($taxData as $tax)
<div class="col-12 col-md-4 col-lg-4">
    <div class="form-group">
        <label>{{ $tax->tax_name }} (%)</label>
        <input type="hidden" class="form-control" name="tax_id[]" value="{{ $tax->id }}">
        <input type="hidden" class="form-control" name="tax_name[]" value="{{ $tax->tax_name }}">
        <input type="text" class="form-control" name="tax_value[]" value="{{ !empty($defaultProdcutTax) && (isset($defaultProdcutTax[$tax->id])) ? $defaultProdcutTax[$tax->id]->value : 0 }}" placeholder="0.00">
    </div>
</div>
@endforeach
@endif