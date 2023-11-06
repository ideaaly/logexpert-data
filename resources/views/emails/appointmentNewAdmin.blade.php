Bonjour,
<br><br>
@if(isset($userReferentName))
Suite à la prise de rendez-vous avec <strong>notre Expert {{ $userReferentName }}</strong>,
nous avons le plaisir de vous informer que l'EDL suivant :<br><br>
@endif

@if(isset($type))
<strong>Type : {{ $type }}<br>
  @if(isset($inventoryRef))Ref : {{ $inventoryRef }}<br>@endif
  @if(isset($tenantName))Locataire : {{ $tenantName }}@endif</strong>
@endif
<br><br>
@if(isset($appointmentDate))
Est programmé pour la date suivante :<br><br>
<strong>{{$appointmentDate}}</strong>
@endif
<br><br>

<br>
Merci.
<br>
Cordialement,<br>
Logexpert<br>
logexpert33.com