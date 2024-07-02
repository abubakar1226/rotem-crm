<form action="{{ route('tables.update', $table->id) }}" method="post" id="{{ $formId }}">
    @csrf
    @method('PUT')

    {{--  Table Management  --}}
    <div class="row g-4">
        <div class="col-lg-6">
            <div class="form-group">
                <label class="form-label border-amb" for="display_name">Display Name</label>
                <div class="form-control-wrap">
                    <input type="text" class="form-control" id="display_name" name="display_name"
                           value="{{ $table?->display_name ?? old('name') }}" required />
                </div>
                @error('name') <smal class="text-danger">{{ $message }}</smal>  @enderror
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label class="form-label" for="description">Description</label>
                <div class="form-control-wrap">
                    <textarea class="form-control" id="description" name="description"
                              required>{{ $table->description }}</textarea>
                </div>
                @error('name') <smal class="text-danger">{{ $message }}</smal>  @enderror
            </div>
        </div>

        <div class="col-lg-6">
            <div class="form-group">
                <label class="form-label" for="fixedColumnsStart">Fixed Columns (Left)</label>
                <div class="form-control-wrap">
                    <input type="number" class="form-control" id="fixedColumnsStart" name="fixedColumnsStart"
                           value="{{ $table->fixedColumnsStart }}" required />
                </div>
                @error('name') <smal class="text-danger">{{ $message }}</smal>  @enderror
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label class="form-label" for="fixedColumnsEnd">Fixed Columns (Right)</label>
                <div class="form-control-wrap">
                    <input type="number" class="form-control" id="fixedColumnsEnd" name="fixedColumnsEnd"
                           value="{{ $table->fixedColumnsEnd }}" required />
                </div>
                @error('name') <smal class="text-danger">{{ $message }}</smal>  @enderror
            </div>
        </div>

        <div class="col-lg-6">
            <div class="custom-control custom-control-md custom-checkbox custom-control pb-2">
                <input type="hidden" value="0" name="scrollX" />
                <input class="custom-control-input permission-checkbox" type="checkbox"
                       {{ $table->scrollX ? 'checked' : '' }} value="1" id="scrollX" name="scrollX" />
                <label class="custom-control-label text-capitalize" for="scrollX">Toggle Horizontal Scroll</label>
            </div>
            @error('scrollX') <smal class="text-danger">{{ $message }}</smal>  @enderror
        </div>

        <hr>

        <h3 class="card-title font-weight-bold">Manage {{ $table->display_name }} Table Columns</h3>
        <div class="py-6 m-auto">
            <ul id="sortable" class="m-auto w-auto p-0">
                @foreach($table->columns as $i => $column)
                    <li class="border rounded-2">
                        <div class="checkbox-group">
                            <input type="hidden" value="{{ $column->id }}" name="columns[{{ $i }}][id]" />
                            <input type="hidden" value="{{ $column->position }}" name="columns[{{ $i }}][position]"
                                   class="position"
                            />
                            <input type="hidden" value="0" name="columns[{{ $i }}][visible]" />
                            <input class="checkbox-normal text-2xl" type="checkbox" value="1"
                                   id="columns[{{ $i }}][visible]" {{ $column->visible ? 'checked' : '' }}
                                   name="columns[{{ $i }}][visible]"
                            />
                            <label class="custom-control-label" for="columns[{{ $i }}][visible]">
                                {{ $column->title }}
                            </label>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</form>
