<div>
    {{-- Close your eyes. Count to one. That is how long forever feels. --}}
    <x-bootstrap.card>
        <x-bootstrap.table>
            <x-slot name="head">
                <tr>
                    <th>Permisson</th>
                    <th>Action</th>
                </tr>
            </x-slot>
            <x-slot name="body">

                @foreach ($permissions->groupBy(fn ($singlePermission) => explode(":", $singlePermission->name)[0]) as $module => $permissionGroup)
                    <tr>
                        <td>{{ $module }}</td>

                        <td class="data_row">
                            @foreach ($permissionGroup as $perm)
                                <x-bootstrap.form.checkbox class="m-2" name="permission.{{ $perm->id }}" label="{{ explode(':', $perm->name)[1] }}" ></x-bootstrap.form.checkbox>
                            @endforeach
                        </td>
                    </tr>
                @endforeach
            </x-slot>
        </x-bootstrap.table>
    </x-bootstrap.card>
</div>
