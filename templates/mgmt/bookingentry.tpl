<tr>
	<td>{message name="$booking->getCustomer()->getFullName()"}</td>
	<td>{$booking->getAdults()}</td>
	<td>{$booking->getChildren()}</td>
	<td>{$booking->getStartDate()}</td>
	<td>{$booking->getEndDate()}</td>
	<td>{$booking->getPromocode()}</td>
	<td><a href="{$cScriptPath}/Bookings?action=edit&id={$booking->getId()}">{message name="edit-boooking"}</a></td>
	<td><a href="{$cScriptPath}/Bookings?action=del&id={$booking->getId()}">{message name="delete-booking"}</a></td>
</tr>
