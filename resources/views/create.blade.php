<x-layout>
    <main class="text-center text-white">
        <form action="{{ route('user.store') }}" enctype="multipart/form-data" class="d-flex flex-column gap-2" method="post">
            @csrf
            <h2>Create User</h2>
            <div class="form-group">
                <label>
                    Name
                    <input class="form-control" type="text" name="name">
                    @error ("name")
                        <span style="color: #581313;">{{ $message }}</span>
                    @enderror
                </label>
            </div>
            <div class="form-group">
                <label>
                    Email
                    <input class="form-control" type="email" name="email">
                    @error ("email")
                        <span style="color: #581313;">{{ $message }}</span>
                    @enderror
                </label>
            </div>
            <div class="form-group">
                <label>
                    Phone
                    <input class="form-control" type="text" pattern="^[\+]{0,1}380([0-9]{9})$" name="phone">
                    @error ("phone")
                        <span style="color: #581313;">{{ $message }}</span>
                    @enderror
                </label>
            </div>
            <div class="form-group">
                <label>
                    Photo
                    <input class="form-control" type="file" name="photo">
                    @error ("photo")
                        <span style="color: #581313;">{{ $message }}</span>
                    @enderror
                </label>
            </div>
            <div class="form-group">
                <label>
                    Position
                    <select class="form-control" name="position_id">
                        @foreach ($positions as $position)
                            <option value="{{ $position->id }}">{{ $position->name }}</option>
                        @endforeach
                    </select>
                    @error ("position_id")
                        <span style="color: #581313;">{{ $message }}</span>
                    @enderror
                </label>
            </div>
            <div class="form-group">
                <button class="btn btn-success">Create</button>
            </div>
        </form>
    </main>
</x-layout>
