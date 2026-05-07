<label>Klant</label>
<select name="customer_id" required>
    @foreach($customers as $customer)
        <option value="{{ $customer->id }}" @selected(old('customer_id', $ticket->customer_id ?? '') == $customer->id)>
            {{ $customer->name }} @if($customer->company)({{ $customer->company }})@endif
        </option>
    @endforeach
</select>

<label>Categorie</label>
<select name="category_id" required>
    @foreach($categories as $category)
        <option value="{{ $category->id }}" @selected(old('category_id', $ticket->category_id ?? '') == $category->id)>{{ $category->name }}</option>
    @endforeach
</select>

<label>Titel</label>
<input name="title" value="{{ old('title', $ticket->title ?? '') }}" required>

<label>Omschrijving</label>
<textarea name="description" rows="6" required>{{ old('description', $ticket->description ?? '') }}</textarea>

<label>Prioriteit</label>
<select name="priority" required>
    @foreach($priorities as $priority)
        <option value="{{ $priority->value }}" @selected(old('priority', isset($ticket) ? $ticket->priority->value : '') === $priority->value)>{{ $priority->label() }}</option>
    @endforeach
</select>

<label>Toegewezen aan:</label>
<select name="assigned_to" id="assigned_to">
    <option value="">Niet toegewezen</option>
    @foreach($users as $user)

        <option value="{{ $user->id }}" @selected(old('assigned_to', isset($ticket) ? $ticket->assigned_to : auth()->id()) === $user->id) > {{ $user->name }}</option>
    @endforeach
</select>

@if(isset($statuses))
    <label>Status</label>
    <select name="status">
        @foreach($statuses as $status)
            <option value="{{ $status->value }}" @selected(old('status', isset($ticket) ? $ticket->status->value : '') === $status->value)>{{ $status->label() }}</option>
        @endforeach
    </select>
@endif
