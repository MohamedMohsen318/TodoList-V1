@php
    $selectedPermissions = old('permissions', $selectedPermissions ?? []);
@endphp

<div style="display: grid; gap: 18px;">
    <div>
        <label for="name" class="label">Role Name</label>
        <input
            id="name"
            name="name"
            type="text"
            class="input"
            value="{{ old('name', $role->name ?? '') }}"
            placeholder="Enter role name"
            required
        >
        @error('name')
            <p class="error">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="label">Permissions</label>
        <div class="panel" style="padding: 16px;">
            @if($permissions->isEmpty())
                <p class="helper" style="margin: 0;">No permissions found for the admin guard.</p>
            @else
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 12px;">
                    @foreach($permissions as $permission)
                        <label style="display: flex; align-items: center; gap: 10px; padding: 10px 12px; border: 1px solid #dbe3f0; border-radius: 12px; background: #fff;">
                            <input
                                type="checkbox"
                                name="permissions[]"
                                value="{{ $permission->name }}"
                                {{ in_array($permission->name, $selectedPermissions, true) ? 'checked' : '' }}
                            >
                            <span>{{ $permission->name }}</span>
                        </label>
                    @endforeach
                </div>
            @endif
        </div>
        @error('permissions')
            <p class="error">{{ $message }}</p>
        @enderror
        @error('permissions.*')
            <p class="error">{{ $message }}</p>
        @enderror
    </div>
</div>
