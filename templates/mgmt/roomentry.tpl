<tr>
	<td>{$room->getName()}</td>
	<td>{message name="{$room->getType()->getName()}"}</td>
	<td>{$room->getMinPeople()}</td>
	<td>{$room->getMaxPeople()}</td>
	<td>&pound;{$room->getPrice()|string_format:"%.2f"}</td>
	<td><a href="{$cScriptPath}/Rooms?action=edit&id={$room->getId()}">{message name="edit-room"}</a></td>
	<td><a href="{$cScriptPath}/Rooms?action=del&id={$room->getId()}">{message name="delete-room"}</a></td>
</tr>
