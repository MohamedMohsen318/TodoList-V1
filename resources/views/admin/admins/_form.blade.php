@csrf

<div style="display: grid; gap: 16px;">
    <div>
        <label class="label" for="name">Name</label>
        <input class="input" id="name" type="text" name="name" value="{{ old('name', $admin->name ?? '') }}" required>
        @error('name') <p class="error">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="label" for="email">Email</label>
        <input class="input" id="email" type="email" name="email" value="{{ old('email', $admin->email ?? '') }}" required>
        @error('email') <p class="error">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="label" for="phone">Phone</label>
        <input class="input" id="phone" type="text" name="phone" value="{{ old('phone', $admin->phone ?? '') }}">
        @error('phone') <p class="error">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="label" for="password">Password</label>
        <input class="input" id="password" type="password" name="password" {{ isset($admin) ? '' : 'required' }}>
        @error('password') <p class="error">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="label" for="roles">Roles</label>
        <select class="select" id="roles" name="roles[]" multiple required style="min-height: 120px;">
            @foreach($roles as $role)
                <option value="{{ $role->name }}" @selected(in_array($role->name, old('roles', $adminRoles ?? []), true))>
                    {{ $role->name }}
                </option>
            @endforeach
        </select>
        @error('roles') <p class="error">{{ $message }}</p> @enderror
    </div>

    <button class="btn btn-primary" type="submit">{{ $submitLabel }}</button>
</div>
