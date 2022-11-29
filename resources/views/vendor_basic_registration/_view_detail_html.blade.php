<div class="modal-header">
  <h5 class="modal-title" id="exampleModalLabel">{{ $vendor_detail->vendor_name }}</h5>
  <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-4 mt-4">
          <strong>Vendor Name </strong><br>
          {{ $vendor_detail->vendor_name }}
        </div>
        <div class="col-md-4 mt-4">
          <strong>Business Name</strong><br>
          {{ $vendor_detail->business_name }}
        </div>
        <div class="col-md-4 mt-4">
          <strong>Mobile</strong><br>
          {{ $vendor_detail->mobile }}
        </div>
        <div class="col-md-4 mt-4">
            <strong>Occupation</strong><br>
            {{ $vendor_detail->occupation }}
        </div>
        <div class="col-md-4 mt-4">
          <strong>State</strong><br>
          {{ $vendor_detail->state }}
        </div>
        <div class="col-md-4 mt-4">
          <strong>City</strong><br>
          {{ $vendor_detail->city }}
        </div>
        <div class="col-md-4 mt-4">
          <strong>Area</strong><br>
          {{ $vendor_detail->area }}
        </div>
        <div class="col-md-4 mt-4">
          <strong>Pincode</strong><br>
          {{ $vendor_detail->pin_code }}
        </div>
        <div class="col-md-4 mt-4">
          <strong>Password</strong><br>
          {{ $vendor_detail->password }}
        </div>
        <div class="col-md-4 mt-4 ">
          <strong>Created Date</strong><br>
          {{ date("d-m-Y h:i A", strtotime($vendor_detail->created_date)) }}
        </div>
    </div>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
  <button type="button" class="btn btn-sm btn-primary">Save changes</button>
</div>