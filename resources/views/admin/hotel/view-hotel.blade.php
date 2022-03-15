@extends('admin.layouts.main')

@section('content')
		<div class="wrapper full bg-ldark">
			<div class="container">
			<h3 class="text-light font-600 border-bottom pb-4 mb-4">View Hotel</h3>

        <div class="bg-dark-2 rounded-20 p-3">
            <div class="d-table mx-auto">
                @if(!empty($result->profile_image))
                <img class="rounded-pill overflow-hidden" width="100px" height="100px" src="{{asset('file/admin/profile').'/'.$result->profile_image}}">
                @else
                <img class="rounded-pill overflow-hidden" width="100px" height="100px" src="{{asset('assets/img/ab.jpg')}}">
                @endif
            </div>
            <div class="row mx-n2 text-center">
                <div class="col px-2 my-3">
                    <div class="border p-3 border-gray rounded-10">
                        <div class="size-18 text-white">Hotel Name</div>
                        <div class="text-light font-400 mt-2 text-gray">{{$result->hotel_name}}</div>
                    </div>
                </div>
                <div class="col px-2 my-3">
                    <div class="border p-3 border-gray rounded-10">
                        <div class="size-18 text-white text-nowrap">Confirguration Contacts</div>
                        <div class="text-light font-400 mt-2 text-gray">{{$result->mobile}}</div>
                    </div>
                </div>
                <div class="col px-2 my-3">
                    <div class="border p-3 border-gray rounded-10">
                        <div class="size-18 text-white text-nowrap"> No. of Extension</div>
                        <div class="text-light font-400 mt-2 text-gray">{{$result->extension}}</div>
                    </div>
                </div>
                <div class="col px-2 my-3">
                    <div class="border p-3 border-gray rounded-10">
                        <div class="size-18 text-white text-nowrap">Billing Contacts</div>
                        <div class="text-light font-400 mt-2 text-gray">{{$result->email}}</div>
                    </div>
                </div>
                <div class="col px-2 my-3">
                    <div class="border p-3 border-gray rounded-10">
                        <div class="size-18 text-white">Status</div>
                        @if($result->is_active == 1)
                        <div class="text-light font-400 mt-2 text-gray">ACtive</div>
                        @else
                        <div class="text-light font-400 mt-2 text-gray">InACtive</div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="border p-3 border-gray rounded-10">
                        <div class="size-18 text-white">Address</div>
                        <div class="text-light font-400 mt-2 text-gray">{{$result->address}}</div>
                    </div>
                </div>
                <div class="col-sm-12 mt-4 mb-4 pb-2">
                   <button  data-toggle="modal" data-target="#deleteModal"  class="btn btn-black border-0 btn-lg w-175">Delete</button>
                 @if($result->is_active == 1)
                    <button class="btn btn-gradient btn-lg w-175" data-toggle="modal" data-target="#deactivateModal">Deactivate</button>
                    @else
                    <button class="btn btn-gradient btn-lg w-175" data-toggle="modal" data-target="#deactivateModal">Activate</button>
                    @endif

                </div>
            </div>
        </div>
        <h5 class="text-white mt-4">Billing Info <span class="arrow-down-circle ml-2 billing_info_id">&#9662;</span></h5>
        <div class="bg-dark-2 rounded-20 p-3 "  id="billing_info" style="display:none;" >
            
            <div class="row mx-0">
                <div class="col mb-2">
                    <div class="size-16 text-white">Last Payment Date</div>
                    <div class="text-light font-400 mt-2 text-gray">{{!empty($billingInfo) ? date('d-m-Y',strtotime($billingInfo->created_at)) : ''}}</div>
                </div>
                <div class="col">
                    <div class="size-16 text-white">Next Due Date</div>
                    <div class="text-light font-400 mt-2 text-gray">{{!empty($billingInfo) ? date('d-m-Y',strtotime($billingInfo->next_due_date)) : ''}}</div>
                </div>
                <div class="col">
                    <div class="size-16 text-white">Amount Due</div>
                    <div class="text-light font-400 mt-2 text-gray">{{!empty($billingInfo) ? '$'.$billingInfo->amount : ''}}</div>
                </div>
            </div>
        </div>
        <h5 class="text-white mt-4">Billing History <span class="arrow-down-circle ml-2 billing_history_id" >&#9662;</span></h5>
        <div class="row" >
            <div class="col-sm-12">
                <div class="table-responsive mb-4"  id="billing_history" style="display:none;">
                    <table class="table theme-default table-borderless">
                        <thead>
                            <tr>
                                <th class="py-3">Date</th>
                                <th class="py-3">Time</th>
                                <th class="py-3">Transaction ID</th>
                                <th class="py-3">Amount</th>
                                <th class="py-3" width="150">Payment Mode</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transDetails as $history)
                            <tr>
                                <td>{{$history->created_at->format('d-m-Y') }}</td>
                                <td>{{$history->created_at->format('h:i A') }}</td>
                                <td>{{$history->transection_id}}</td>
                                <td>${{$history->amount}}</td>
                                @if($history->payment_type == 1)
                                <td>Credit Card</td>
                                @else
                                <td>Debit Card</td>
                                @endif
                            </tr>
                           @endforeach
                           
                        </tbody>
                    </table>
                </div>
                <a href="{{url('admin/manage-hotel')}}"> <button class="btn btn-secondary btn-lg w-175 border-0 py-3">Back</button></a> 
            </div>
        </div>
			</div>
		</div>
<div class="modal fade" id="deactivateModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content bg-black rounded-20">
      <div class="modal-body text-center py-5">
        <h3 class="text-white px-4 font-300">Are you sure you want to Changes?</h3>
		<div class="text-center mt-5">
			<button type="button" class="btn btn-secondary border-0 rounded-15 btn-lg w-150 py-3 mx-3" data-dismiss="modal">No</button>
		
         <button type="button" onclick="deactivatehotel()"  id="deactivate" class="btn btn-gradient border-0 rounded-15 btn-lg w-150 py-3 mx-3">Yes</button>
		</div>
      </div>
    </div>
  </div>
</div> 
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content bg-black rounded-20">
      <div class="modal-body text-center py-5">
        <h3 class="text-white px-4 font-300">Are you sure you want to Delete?</h3>
		<div class="text-center mt-5">
			<button type="button" class="btn btn-secondary border-0 rounded-15 btn-lg w-150 py-3 mx-3" data-dismiss="modal">No</button>
		
         <button type="button" onclick="deletehotel()"  id="delete" class="btn btn-gradient border-0 rounded-15 btn-lg w-150 py-3 mx-3">Yes</button>
		</div>
      </div>
    </div>
  </div>
</div> 

@endsection

@section('script')

<script>
    function deactivatehotel(){
        window.location.href = "{{url('admin/manage-hotel/deactivate',$result->id)}}";
      
       
    }
    function deletehotel(){
        window.location.href = "{{url('admin/manage-hotel/delete',$result->id)}}";
       
    }

    

    $('.billing_info_id').on('click', function (event) {
       $( "#billing_info" ).toggle( "show", function() {     
        });

    });

    $('.billing_history_id').on('click', function (event) {
        $( "#billing_history" ).toggle( "show", function() {
          
        });

    });
    
   
</script>

@endsection

