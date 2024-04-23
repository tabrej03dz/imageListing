@extends('backend.layout.root', ['title' => 'Customers'])
@section('content')
    <div class="flex items-center justify-between mb-8">
        <h2 class="text-3xl font-bold text-gray-800">Customers</h2>
        <a href="{{route('customer.create')}}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Add Customer</a>
    </div>

    @if($customers->count() > 0)
        <table class="min-w-full divide-y divide-gray-200">
            <thead>
            <tr>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">S. No</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Name</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Email</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Phone</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
            @foreach($customers as $customer)
                <tr>
                    <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-500">{{$loop->iteration}}</td>
                    <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-500">{{$customer->name}}</td>
                    <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-500">{{$customer->email}}</td>
                    <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-500">{{$customer->phone}}</td>
                    <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-500">
                        {{-- Edit and Delete buttons --}}
                        {{-- You can uncomment and modify these links as needed --}}
                         <a href="{{ route('customer.edit', ['customer' => $customer]) }}" class="inline-block bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded mr-2">Edit</a>
                         <a href="{{ route('customer.destroy', ['customer' => $customer]) }}" class="inline-block bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded mr-2">Delete</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

    @else
        <p>No customers found.</p>
    @endif

@endsection
