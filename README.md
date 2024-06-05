# Test effettuati per la validazione

Tra le varie librerie viste per la validazione, a causa dell'algoritmo <strong>RS256</strong>, <br />
è impossibile senza ricreare la chiave public e private (pem,pub) poter validare il jwt token. <br />
Dall'esempio nella pagina <a href="C:\web\Progetti\BluArancio\jwt-validate\src\tester.php">tester</a>, posso estrarre header e payload ma non posso validarlo.

Ho provato con il plugin di fribase, ma attraverso le funzionalità open ssl si rompe in quanto la chiave è formata male
Mentre in node js, si può fare la validazione

## test con node

Il test con node funziona correttamente, ma devo chiamare in sequenza due promise:
- quella per estrarre la lista dei certificati
- la seconda post prima, per validare il token
se tutte e due sono andate a buon fine dovrei passare la palla a php per la parte della logi richiamando una terza api, 
che esegue:
- inserisce lo user se questo non è mappato
- genera il keycloak da passare al FE per essere messo nel vuex, in modo tale che il sistema riconosca l'utente e quindi possa procedere con l'uso del portale

La mia preocupazione è le tempiste relative alla gestione di tutto ciò che potrebbe richiedere anche qualche minuto

### Soluzione

1. l'api dei certs di demetra, chiamarla all'inizio all'arrivo sul sistema(configurazioni), e metterla dentro il vuex; al più ogni ora un reload di questa;
1a. oppure la chiamo a parte, solo quando il portale è demetra (però poi devo sempre aspettare che vada nel vuex)
2. potrei passare tutta la palla a php ?????
3. si potrebbe ok entro con demetra demando a php:
   - chiama api demetra per i certificati
   - esegue uno script node per la validazione
   - fa la login