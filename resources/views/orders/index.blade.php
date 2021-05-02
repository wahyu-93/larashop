@extends('layouts.global')

@section('title')
    Order List
@endsection

@section('content')
    {{-- pencarian --}}
    <form action="{{ route('orders.index') }}">
        <div class="row">
            <div class="col-md-5">
                <input 
                    type="text"
                    name="buyer_email"
                    class="form-control"
                    placeholder="Search by buyer email"
                    value="{{ Request::get('buyer_email') }}">
            </div>

            <div class="col-md-2">
                <select name="status" id="status" class="form-control">
                    <option value="">ANY</option>
                    <option 
                        {{ Request::get('status') == 'SUBMIT' ? 'selected' : ''  }}  
                        value="SUBMIT">SUBMIT
                    </option>

                    <option 
                        {{ Request::get('status') == 'PROCESS' ? 'selected' : ''  }}  
                        value="PROCESS">PROCESS
                    </option>

                    <option 
                        {{ Request::get('status') == 'FINISH' ? 'selected' : ''  }}  
                        value="FINISH">FINISH
                    </option>

                    <option 
                        {{ Request::get('status') == 'CANCEL' ? 'selected' : ''  }}  
                        value="CANCEL">CANCEL
                    </option>
                </select>
            </div>

            <div class="col-md-2">
                <input 
                    type="submit"
                    value="Filter"
                    class="btn btn-primary">
            </div>
        </div>
    </form>

    <hr class="my-3">
    
    <div class="row">
        <div class="col-md-12">
            <table class="table table-stripped table-bordered">
                <thead>
                    <tr>
                        <th>Invoice Number</th>
                        <th><b>Status</b></th>
                        <th><b>Buyer</b></th>
                        <th><b>Total Quantity</b></th>
                        <th><b>Order Date</b></th>
                        <th><b>Total Price</b></th>
                        <th><b>Actions</b></th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td>{{ $order->invoice_number }}</td>
                            <td>
                                @if($order->status == "SUBMIT")
                                    <span class="badge bg-warning text-light">{{ $order->status }}</span>
                                @elseif($order->status == "PROCESS")
                                    <span class="badge bg-info text-light">{{ $order->status }}</span>
                                @elseif($order->status == "FINISH")
                                    <span class="badge bg-success text-light">{{ $order->status }}</span>
                                @elseif($order->status == "CANCEL")
                                    <span class="badge bg-dark text-light">{{ $order->status }}</span>
                                @endif
                            </td>

                            <td>
                                {{ $order->user->name }}
                                <small class="badge bg-info text-light">{{ $order->user->email }}</small>
                            </td>
                            
                            <td>{{ $order->totalQuantity }} pc (s)</td>
                            <td>{{ $order->created_at }}</td>
                            <td>{{ $order->total_price }}</td>
                            <td>
                                <a 
                                    href="{{ route('orders.edit', ['id' => $order->id]) }}"
                                    class="btn btn-info btn-sm">Edit
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>

                <tfoot>
                    <tr>
                        <td colspan="10">
                            {{ $orders->appends(Request::all())->links() }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection