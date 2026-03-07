@extends('layouts.admin')

@section('title', 'All Product Reviews')

@section('content')
<div class="container mt-4">
    <h1>Product Reviews</h1>
    <table id="reviews-table" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Product</th>
                <th>User</th>
                <th>Rating</th>
                <th>Review</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
@endsection

@push('scripts')
<script>
$(function() {
    $('#reviews-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('admin.reviews.index') }}',
        columns: [
            { data: 'review_id', name: 'review_id' },
            { data: 'product_name', name: 'product.product_name' },
            { data: 'user_name', name: 'user.full_name' },
            { data: 'rating', name: 'rating' },
            { data: 'review_text', name: 'review_text' },
            { data: 'review_date', name: 'review_date' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ]
    });
});
function deleteReview(id) {
    if(confirm('Delete this review?')) {
        $.ajax({
            url: '/admin/reviews/' + id,
            type: 'DELETE',
            data: { _token: '{{ csrf_token() }}' },
            success: function() { $('#reviews-table').DataTable().ajax.reload(); }
        });
    }
}
</script>
@endpush
