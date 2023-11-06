Bonjour,
<br><br>
@if(isset($userReferentName))
Suite à la prise de rendez-vous avec <strong>notre expert(e) {{ $userReferentName }}</strong>,
nous avons le plaisir de vous informer que votre
@endif

@if(isset($type))
<u>{{ $type }}</u>
@endif

@if(isset($appointmentDate))
est programmé pour la date suivante :<br><br>
<strong>le {{$appointmentDate}}</strong>
@endif
<br><br>
En cas de difficulté le jour du RDV, merci de contacter :<br><br>
@if(isset($userReferentName))
<strong>{{ $userReferentName }}</strong><br>
@endif
@if(isset($userReferentTel))
<strong>{{ $userReferentTel }}</strong><br>
@endif
<br>
Merci.
<br>
Cordialement,<br>
Logexpert<br>
logexpert33.com