
# IS-115-Chatbot-i-PHP

Dette er en obligatorisk oppgave i faget **IS-115 Webprogrammering i PHP**.
Applikasjonen er en **regel-basert chatbot** som svarer på **UiA-relaterte spørsmål** ved å analysere tekst, identifisere relevante nøkkelord og sammenligne disse med lagrede spørsmål og svar i databasen.

## Kort om hvordan chatboten fungerer

1. Brukerens spørsmål tas inn som en tekststreng.
2. Teksten deles opp i ord.
3. Stopwords fjernes(ved å sjekke opp mot et array som inneholder typiske stopwords).
4. Ordene normaliseres til grunnform (f.eks. *biler* → *bil*) ved hjelp av et NLP-API.
5. De rensede ordene sendes videre til et synonym-API.
6. Alle ord (inkludert synonymer) sjekkes mot nøkkelordene som ligger lagret i databasen.
7. Matcher chatboten ett eller flere nøkkelord, henter den frem tilhørende spørsmål og svar
8. Disse spørsmålene og svarene blir deretter kjørt gjennom et scoring algoritme som velger ut spørsmålet med høyest score.
9. Spørsmål og svar med høyest score blir vist til brukeren sammen med tidliggere stilte spørsmål

Den enkleste gratis tilgjengelige API-ene vi fant for lemmatisering og synonymer var engelske. Vi valgte derfor å gjøre hele webapplikasjonen på engelsk (UI, spørsmål, svar og nøkkelord).

---

## Teknisk oversikt

* Backend: PHP (prosjekt i tråd med IS-115-oppsett)
* Webserver/database: XAMPP (Apache + MySQL)
* Datamodell:

  * Egen tabell for nøkkelord
  * Egen tabell for spørsmål/svar
  * Egentabell for brukere
  * Egentabell for kategorier
  * Spørsmål kobles til opptil 10 nøkkelord (se Figur 4 i skjermbildene)
* Eksterne API-er:

  * NLPCloud (lemmatisering / normalisering av ord)
  * Synonym-API (engelsk) for å utvide brukerens ord til flere relevante varianter
* Viktig: Chatboten bruker **ikke** et generativt AI-API for å lage svar. Alle svar er forhåndsdefinerte i databasen og styres via nøkkelord.
* Viktig: Lemma funksjon funker kun om Api key fra NLP cloud blir puttet i en text.text fil i root, i søskenmappe til app og public

---

## Steg for å kjøre prosjektet

1. **Installer XAMPP**

   Last ned og installer XAMPP (Apache + MySQL).

2. **Start server og database**

   Åpne XAMPP Control Panel og start:

   * `Apache`
   * `MySQL`




3. **Plasser prosjektet i `htdocs`**

   * Klon eller kopier prosjektet inn i XAMPP sin `htdocs`-mappe, f.eks.:
     `C:\xampp\htdocs\chatbot\`

4. **Hent API-nøkkel fra NLPCloud**

   * Gå til: [https://nlpcloud.com/](https://nlpcloud.com/)
   * Opprett en gratis bruker.
   * Generer en gratis API-nøkkel.
   * Lag en fil, `text.text`, og legg inn API-nøkkelen der.

     * Filen brukes av applikasjonen til å lese API-nøkkelen uten å hardkode den i koden.

5. **Åpne applikasjonen i nettleseren**

   Skriv inn følgende URL i nettleseren:

   ```text
   http://localhost/chatbot/IS-115-Chatbot-i-PHP/public
   ```

   Du vil først bli sendt til innloggingssiden siden du ikke er logget inn.

---

## Brukerinnlogging

Du kan enten:

* Logge inn med en eksisterende admin-bruker, eller
* Registrere en ny bruker via registreringsskjemaet.

Eksempel på admin-bruker som kan brukes ved testing:

* **Email:** `admin@gmail.com`
* **Passord:** `Password123@`

Etter innlogging vil du komme til hovedsiden der du kan stille spørsmål til chatboten.
<img width="2556" height="1386" alt="image" src="https://github.com/user-attachments/assets/5f244dd2-b517-4e03-8283-43be9d4d152f" />


---

## Brukerside (chatvisning)

1. Brukeren skriver inn et spørsmål i tekstfeltet.
2. Chatboten analyserer teksten, finner nøkkelord og forsøker å matche disse mot databasen.
3. Dersom for eksempel en bruker skriver *"food"*, og `food` finnes som nøkkelord, vil chatboten gi standard svar om at den ikke klarte å finne spørsmålet.

Spørsmål og nøkkelord administreres i tabellene slik som vist i databasediagrammet/skjermbildet.

---

## Adminside

Forskjellen mellom brukersiden og adminsiden er:

* På **brukersiden** kan man kun stille spørsmål og lese svar.
* På **adminsiden** kan man i tillegg:

  * Opprette nye spørsmål og svar.
  * Knytte opptil **10 nøkkelord** til hvert spørsmål.
  * På den måten styre hvilke brukerinnputt som skal trigge hvilke spørsmål/svar.
  * Redigere og slette bruker innformasjon.

Dette gir en fleksibel, regelbasert FAQ-chatbot der administrator kan bygge ut kunnskapsbasen over tid uten å endre selve koden.



   



   
