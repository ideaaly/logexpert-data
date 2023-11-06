Bonjour,

<br><br>

Un ordre de mission vous a été attribué :
<br><br>

@if(isset($type))
<strong>Type de bien :<br></strong>
{{ $type }}
<br><br>
@endif

@if(isset($dateWanted))
<strong>À programmer avec le locataire pour le :</strong><br>
{{ $dateWanted }}
<br><br>
@endif

@if(isset($dateWanted))
<strong>Notes :</strong><br>
{{ $tenantNotes }}
<br><br>
@endif

@if(isset($keyNotes))
<strong>DÉPOSE/REMISE DES CLÉS :</strong><br>
{{ $keyNotes }}
<br><br>
@endif

@if(isset($permalink))
<a href="{{ $permalink }}">Prendre rendez-vous sur la plateforme en cliquant ici.</a>
<br><br>
@endif

Merci de prendre RDV rapidement avec le locataire.
<br><br>
Cordialement,<br>
Logexpert<br>
06-79-62-61-99<br>
logexpert33.com