
    @inject('roles','App\Role')
    
    <div class="form-group">
        <label for="name">User Name</label>
            {!! Form::text('name',null, [
            'class' => 'form-control'
            ]) !!}
    </div>
    <div class="form-group">
        <label for="email">Email</label>
            {!! Form::email('email',null, [
            'class' => 'form-control'
            ]) !!}
    </div>
    <div class="form-group">
        <label for="email">phone</label>
            {!! Form::text('phone',null, [
            'class' => 'form-control'
            ]) !!}
    </div>
    <div class="form-group">
        <label for="password">Password</label>
            {!! Form::password('password', [
            'class' => 'form-control'
            ]) !!}
    </div>
    <div class="form-group">
        <label for="password_confirmation">Password</label>
            {!! Form::password('password_confirmation', [
            'class' => 'form-control'
            ]) !!}
    </div>
    <div class="form-group">
        <label for="roles">Roles</label>
            {!! Form::select('roles_list[]', $roles->pluck('display_name', 'id')->toArray(), null, [
            'class'    => 'form-control select2',
            'multiple' => 'multiple'
            ]) !!}
    </div>
   
