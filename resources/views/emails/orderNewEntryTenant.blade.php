Bonjour,
<br><br>

Nous vous informons que l'
@if(isset($type))
<u>{{ $type }}</u>
@endif
de votre nouveau logement situé à l'adresse suivante :<br><br>

@if(isset($address1)){{ $address1 }}<br>@endif
@if(isset($address2)){{ $address2 }}<br>@endif
@if(isset($zip_code)){{ $zip_code }}@endif - @if(isset($city)){{ $city }}<br>@endif
<br>
@if(isset($dateWanted))
Sera effectué le :<br>
{{ $dateWanted }} avec la remise des clés sur place.
@endif
<br><br>
Il sera effectué par la Société LOGEXPERT qui va vous contacter afin de convenir de l’heure de ce rendez-vous.
<br><br>
Pour toute information, vous pouvez contacter notre service technique au <br>
<u>05 56 90 49 93 (8h30-12h30 / 14Hh00 du lundi au jeudi / 17h00 le vendredi)</u>.<br><br>
Vous pouvez, si vous le désirez, vous faire représenter par une tierce personne.
<br><br>
Nous vous remercions par avance de votre présence à ce rendez-vous et restant à votre écoute,<br><br>
Bien cordialement<br>SERVICE ETATS DES LIEUX