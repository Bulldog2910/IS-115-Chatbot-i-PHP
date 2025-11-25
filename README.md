# IS-115-Chatbot-i-PHP
Dette er en oppgave i faget Webprogrammering i php (IS-115). Nettsiden vil være en chatbot som svarer på spørsmål som brukere stiller innenfor et tema.

Steg for å kjøre prosjektet:
1. Last ned xammp
2. Start en server og database på xammp appen som anvist på bildet under:

<img width="817" height="520" alt="xampp bilde" src="https://github.com/user-attachments/assets/e36a5c81-679a-4f64-a289-ef2ba4123a20" />
Figur: 1.

4. Skriv inn denne lenken i nettleser: http://localhost/chatbot/IS-115-Chatbot-i-PHP/app/views/login.php


Den vil ta deg til login siden, der kan du skrive inn email: elias.simonsen@wemail.no og passord pokemon. 
<img width="810" height="786" alt="loggin" src="https://github.com/user-attachments/assets/28020bf7-3b0f-452d-b3bd-69b0ab87abc9" />
Figur: 2.

Etter du har logget inn vil du komme til hovedsiden for brukeren der du kan stille spørsmål til chatbotten:
<img width="882" height="896" alt="hovedsiden" src="https://github.com/user-attachments/assets/b0844e15-793d-4fab-9f91-f0db7abc509d" />
Figur: 3.

Hvordan fungerer chatboten?

Brukersiden:

1. Chatboten bruker ikke en api for å svare brukeren, dette var et bevvist valg av oss ettersom vi ikek fant noen passende api som var gratis.
2. Chatboten benytter nøkkelord fra brukerens spørsmål. Dersom en bruker for eksempel skriver «mat», identifiserer chatboten dette som et nøkkelord
   og presenterer relevante spørsmål som brukeren kan velge mellom innenfor temaet mat. Det gjøres i denne tabellen:
   <img width="602" height="670" alt="question" src="https://github.com/user-attachments/assets/c7a5ae3f-aef7-4afe-976c-a0fde6fa22f6" />
    Figur: 4.
   

Adminsiden:

1. Forskjellen på brukersiden og adminsiden er at på adminsiden kan man lage spørsmål.
2. Etter man har laget et spørsmål så kan man knytte opp til 10 keywords til det, som henvist på figur 4.
   



   
