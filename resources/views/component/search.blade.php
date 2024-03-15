<div class="col-md-4 my-3">
    <form class="d-flex align-items-center">
        @if (request(['start_date', 'end_date']))
            <input type="hidden" name="start_date" value="{{ request('start_date') }}">
            <input type="hidden" name="end_date" value="{{ request('end_date') }}">
        @endif
        <label for="search">Search :</label>
        <input type="text" id="search" name="search" class="form-control" placeholder="Cari...">
    </form>
</div>