@extends('layouts.mainLayout')
@section('content')
  <div class="container card documentationTitle">
    <h1>Documentazione Progetto Boolbnb</h1>
    <h6><small>Progetto sviluppato da Giacomo Suffredini, Alberto Germanà, Alessandro Cinquetti, Nicolò Battaglia e Marco De Lorenzi</small></h6>
  </div>
  <div class="documentation container card">
    <div class="row">
      <div class="col-sm-12">
        <h2>Cosa è Boolbnb</h2>
        <p>Boolbnb è un’applicazione web sviluppata dal <b>Team3</b> della <b>Classe 11</b> di <b>Boolean Careers</b>. <br>
          Permette ad un utente di <b>cercare</b> e <b>visualizzare annunci di appartamenti</b> in base ad alcuni filtri (indirizzo, distanza e servizi ecc) e di contattare il proprietario di ogni appartamento. Permette anche la <b>registrazione</b> e dunque il <b>login</b>.<br> <b>Ciascun utente registrato ha la possibilità di creare un annuncio per un suo appartamento, tale annuncio sarà modificabile, eliminabile, sponsorizzabile e permetterà la ricezione di messaggi da altri utenti</b>.</p>

        <h3>Intestazione e piè di pagina</h3>
        <p>In tutte le pagine (tranne la dashboard personale) l'intestazione e il piè di pagina sono sempre uguali. L'intestazione è differente tra utente registrato e utente non registrato poiché nel primo caso viene visualizzato il nome dell'utente e scompaiono i tasti di registrazione e login. Il piè di pagina contiene collegamenti ai profili LinkedIn degli sviluppatori del progetto, dei teacher e staff di BooleanCareers e le tecnologie utilizzate per lo sviluppo.</p>

        <h3>Home Page</h3>
        <p>La <b>pagina iniziale</b>, con la grafica minimal, invoglia subito l'utente a <b>cercare una meta</b> presso cui alloggiare, suggerendogli alcuni luoghi famosi grazie allo slider di monumenti. Nella seconda metà della pagina sono mostrati gli appartamenti sponsorizzati attualmente attivi. Per <b>effettuare una ricerca</b> basta scrivere il nome della città (o addirittura l’indirizzo) nel campo di testo e premere invio o il pulsante dedicato.</p>

        <h3>Pagina di dettaglio</h3>
        <span>La pagina di <b>dettaglio dell’appartamento</b> ne <b>mostra tutte le caratteristiche</b>.
          In alto troviamo il titolo e l’indirizzo, subito sotto troviamo una <b>grande card</b> con il resto delle <b>info</b>:
          l’immagine ingrandita in modo da permettere all’utente di avere una visione più chiara dell’appartamento, la descrizione (scrollabile in base alla lunghezza), il dettaglio del numero di stanze, posti letto e bagni, la metratura e l’elenco dei servizi forniti. A destra troviamo <b>la mappa</b> che con un marker indica l'ubicazione esatta dell’appartamento. <br>
          Inoltre questa <b>pagina è diversa in base all'utente che la visualizza</b>: </span>
            <ul>
              <li>L'<b>utente non registrato</b> può inviare un messaggio al proprietario dell'appartamento inserendo una mail e la sua domanda nel form dedicato</li>
              <li>L'<b>utente registrato NON proprietario</b>, può inviare un messaggio al proprietario dell'appartamento. Il campo mail sarà pre-compilato con la mail di registrazione</li>
              <li>Il <b>proprietario</b> non può auto-inviarsi un messaggio! Al posto del form troverà un <b>pannello di controllo</b> relativo all'appartamento, in particolare:
                <ul>
                  <li>Se l'appartamento non è sponsorizzato, vedrà i bottoni per modificarlo, cancellarlo, vederne le statistiche o sponsorizarlo.</li>
                  <li>Se l'appartamento è sponsorizzato, vedrà solo i bottoni per modificarlo, cancellarlo, vederne le statistiche.</li>
                </ul>
              </li>
            </ul>
            <p><b>L'utente non può inviare un nuovo messaggio se non sono trascorsi 10 secondi dal suo ultimo invio</b>.</p>

        <h3>Registrazione e login</h3>
        <p>In qualsiasi pagina del sito è possibile fare la registrazione o login, cliccando nella sezione dedicata dell’intestazione di pagina.<br>
        Cliccando su "Registrati" l'utente viene reindirizzato in una pagina con un form di registrazione contenente dei campi obbligatori quali nome, mail e password e campi non obbligatori quali cognome e data di nascita.<br> Il form di registrazione controlla che i dati obbligatori vengano inseriti e che siano coerenti con la tipologia di dato richiesta (esempio la mail deve contenere la @ e il punto). Nel caso in cui i dati inseriti non soddisfino determinati controlli verrà restituito un messaggio in alto con uno o più suggerimenti. Se la registrazione va a buon fine, e al login, l'utente viene subito reindirizzato nella dashboard. </p>

        <h3>Pagina di ricerca</h3>
        <p>Nella pagina di ricerca l'utente trova in alto la <b>SearchBox</b> con il campo ricerca già compilato con la query inserita nella Home Page, un <b>tasto “cerca”</b> nel caso in cui volesse farne un'altra e il <b>tasto “più filtri”</b> per raffinarla. <br>
        Quest’ultimo tasto, se premuto, fa <b>apparire un prolungamento della SearchBox</b> che permette di inserire <b>parametri di ricerca più restrittivi</b>: numero di stanze, posti letto, e distanza in chilometri rispetto al punto cercato. Inoltre è possibile indicare quali <b>servizi</b> l'appartamento deve avere per comparire in ricerca. I servizi disponibili sono: Wi-Fi, Posto Auto, Piscina, Portineria, Sauna e Vista Mare. Un secondo click sul tasto “più filtri” nasconde il prolungamento. <br>
        <b>Sotto la SearchBox</b> si estende la <b>lista dei risultati filtrati</b> in base ai parametri di ricerca: per primi verranno mostrati gli appartamenti sponsorizzati poi in <b>ordine di distanza</b> (dal più vicino al lontano) gli altri appartamenti.<br>
        In formato Card, <b>ogni risultato fornisce informazioni sull’appartamento</b>: il <b>Titolo</b>, la <b>Descrizione</b> (con un numero limitato di caratteri), il <b>Proprietario</b> dell'appartamento, i <b>Servizi disponibili</b>, e nel caso degli annunci non sponsorizzati la distanza dall'indirizzo inserito in ricerca (in m se sotto il chilometro, in km se sopra).<br>
        La card reagisce al passaggio del mouse con un leggerissimo ingrandimento ed è possibile interagire con essa cliccando sul titolo o l’immagine dell’appartamento portandoci nel <b>dettaglio dell'annuncio</b>.</p>

        <h3>Sponsorizzazione</h3>
        <p>E’ possibile <b>sponsorizzare il proprio annuncio</b> sia cliccando sul tasto "Sponsor" nella pagina di dettaglio sia cliccando sull'apposita icona nella dashboard.
          La pagina dello sponsor permette la scelta di <b>tre tariffe</b>:
          <div class="tariffe">
            <ul>
              <li><b>Silver</b> </li>
              <li>2.99€</li>
              <li>24 Ore</li>
            </ul>
            <ul>
              <li><b>Gold</b> </li>
              <li>5.99€</li>
              <li>72 Ore</li>
            </ul>
            <ul>
              <li><b>Platinum</b> </li>
              <li>9.99€</li>
              <li>144 Ore</li>
            </ul>
          </div>

          Scelto uno sponsor si attiva il pulsante per il <b>pagamento</b> e una volta cliccato è possibile inserire i dati della <b>carta di credito</b> per procedere all’acquisto. L’esito del pagamento viene comunicato in alto alla pagina. Una volta attivato lo sponsor per un appartamento <b>non è possibile cambiarne le caratteristiche o attivarne altri finché lo sponsor non scade</b>.</p>

        <h3>Dashboard</h3>
        <span>
          Questa è la <b>sezione più personale</b> del sito, infatti qui si trovano <b>tutti i dati relativi all'utente registrato</b>.
          In alto è presente la barra con il <b>tasto</b> per <b>creare un nuovo annuncio</b> e una sezione che al passaggio del mouse mostra la legenda delle icone riportate utilizzate.
          Sotto questa barra si trova l'intera <b>lista dei propri appartamenti</b>, partendo da quelli sponsorizzati.
          A ciascun appartamento è dedicata una card che si adatta in base alle caratteristiche all'appartamento:</span>
          <ul>
            <li>Se l'<b>appartamento è sponsorizzato</b>
              <ul>
                <li>La card mostra una <b>coccarda</b> blu navy su sfondo dorato in alto a destra</li>
                <li>Passando il mouse sopra la coccarda sarà mostrato un <b>timer</b> che indica il tempo restante di sponsorizzazione</li>
                <li>Sono presenti <b>tre icone</b>: modifica, cancella e mostra statistiche dell'appartamento</li>
                <li>L'icona per sponsorizzare l'appartamento non è presente</li>
              </ul>
            </li>
          </ul>
          <ul>
            <li>Se l'<b>appartamento non è sponsorizzato</b>
              <ul>
                <li>Sono presenti <b>quattro icone</b>: sponsorizza, modifica, cancella e mostra statistiche dell'appartamento</li>
                <li>L'icona per sponsorizzare l'appartamento è presente</li>
              </ul>
            </li>
          </ul>
          <p> A destra troviamo la <b>sezione dedicata</b> ai <b>messaggi ricevuti</b>, ordinati <b>dal più recente al meno recente</b>. A ciascun messaggio è dedicata una card che mostra l'appartamento per il quale si chiedono informazioni (con una coccarda dorata se l'appartamento è sponsorizzato), la mail da usare per ricontattare l'utente interessato, data e orario di ricezione, e il testo del messaggio.</p>

        <h3>Statistiche</h3>
        <p>Per ogni appartamento il proprietario può <b>visualizzare le statistiche mensili</b> di visualizzazioni e dei messaggi ricevuti. Le statistiche mostrano dati di un <b>range temporale di un anno</b> dal momento in cui vengono visualizzate.</p>

        <h3>Creare Annuncio</h3>
        <p>Cliccando sul <b>tasto "Crea annuncio"</b> nella dashboard si viene reindirizzati in una pagina con un form in cui ogni campo è obbligatorio. <b>I dati inseriti sono controllati sia lato front-end che back-end</b>. Il proprietario può decidere se rendere subito attivo l’annuncio (dunque visibile alla ricerca) del proprio appartamento o riattivarlo successivamente. <b>Il tasto che crea</b> l'appartamento <b>rimane disattivo finché ogni campo non viene valorizzato correttamente</b>. Se la creazione avviene con successo si è reindirizzati alla pagina di dettaglio dell'appartamento appena inserito.<br> <b>Per creare un altro annuncio l'utente dovrà attendere 30 secondi</b>.</p>

        <h3>Modificare un Annuncio</h3>
        <p>E’ possibile <b>modificare un proprio</b> annuncio sia cliccando sul tasto "Modifica" nella pagina di dettaglio sia cliccando sull'apposita icona nella dashboard.
          Anche in questa pagina <b>i dati inseriti sono controllati sia lato front-end che back-end</b>. Il proprietario può cambiare qualunque informazione desideri. Il <b>tasto che modifica</b> l'appartamento <b>si disattiva se un valore non viene valorizzato correttamente</b>. Se la modifica avviene con successo si è reindirizzati alla pagina di dettaglio dell'appartamento modificato.</p>

        <h3>Aspetto e Responsiveness</h3>
        <p>L'<b>aspetto</b> del sito è pensato per rimanere <b>costante e coerente</b> in ogni sua pagina così da offrire un'<b>esperienza utente fluida, intuitiva e familiare</b>. <br>
         La gerarchia degli elementi mostrati è assicurata grazie a un <b>effetto profondità</b> che accomuna gli elementi con la stessa importanza. L'<b>interazione dell'utente</b> su un elemento della pagina ne aumenta l'importanza e dunque l'impatto visivo. <br> <b>L'intera applicazione è totalmente responsive: supporta tutte le risoluzioni di tutti i più comuni devices.</b> </p>
      </div>
    </div>
  </div>
@endsection
