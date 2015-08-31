<?php
/*
* Language file for Help Desk Software HESK (www.hesk.com)
* Language: ITALIANO
* Version: 2.6.1
* Author: Klemen Stirn (http://www.hesk.com) ; Marco Borla (http://www.peopleinside.it)
*
* !!! This file must be saved in UTF-8 encoding without byte order mark (BOM) !!!
* Test chars: àáâãäåæ
*/

// Change "English" to the name of your language
$hesklang['LANGUAGE']='Italiano';

// Language encoding. It MUST be set to UTF-8 for all languages!
$hesklang['ENCODING']='UTF-8';

// MySQL utf8 collation. Do not change if not sure what to use.
$hesklang['_COLLATE']='utf8_unicode_ci';

// This is the email break line that will be used in email piping
$hesklang['EMAIL_HR']='------ Rispondi sopra questa linea ------';

// EMAIL SUBJECTS
$hesklang['new_ticket_staff']       = '[#%%TRACK_ID%%] Nuovo ticket: %%SUBJECT%%';
$hesklang['ticket_received']        = '[#%%TRACK_ID%%] Ticket ricevuto: %%SUBJECT%%';
$hesklang['ticket_assigned_to_you'] = '[#%%TRACK_ID%%] Ticket assegnato: %%SUBJECT%%';
$hesklang['new_reply_by_customer']  = '[#%%TRACK_ID%%] Nuova risposta a: %%SUBJECT%%';
$hesklang['new_reply_by_staff']     = '[#%%TRACK_ID%%] Nuova risposta a: %%SUBJECT%%';
$hesklang['category_moved']         = '[#%%TRACK_ID%%] Ticket spostato: %%SUBJECT%%';
$hesklang['new_note']               = '[#%%TRACK_ID%%] Nota inserita a: %%SUBJECT%%';
$hesklang['new_pm']                 = 'Nuovo messaggio privato: %%SUBJECT%%';
$hesklang['forgot_ticket_id']       = 'Elenco dei tuoi ticket di supporto';
$hesklang['ticket_closed']			= '[#%%TRACK_ID%%] Ticket chiuso/risolto'; // New in 2.6.0

// ERROR MESSAGES
$hesklang['cant_connect_db']='Impossibile connettersi al database!';
$hesklang['invalid_action']='Azione non valida';
$hesklang['select_username']='Per favore scegli il tuo nome utente';
$hesklang['enter_pass']='Per favore inserisci la tua password';
$hesklang['cant_sql']='Impossibile eseguire SQL';
$hesklang['contact_webmsater']='Per favore segnala questo errore al webmaster scrivendo a';
$hesklang['mysql_said']='Errore MySQL';
$hesklang['wrong_pass']='Password non valida';
$hesklang['session_expired']='La tua sessione è scaduta, accedi nuovamente utilizzando il form seguente.';
$hesklang['attempt']='Tentativo non valido!';
$hesklang['not_authorized_tickets']='Non sei autorizzato a visualizzare i ticket presenti in questa categoria!';
$hesklang['must_be_admin']='Non sei autorizzato a visualizzare questa pagina! Per visualizzare questa pagina devi effettuare il login come amministratore';

$hesklang['no_session']='Impossibile avviare una nuova sessione!';
$hesklang['error']='Errore';
$hesklang['int_error']='Errore interno dello script';
$hesklang['no_trackID']='Nessun codice del ticket';
$hesklang['status_not_valid']='Stato non valido';
$hesklang['trackID_not_found']='Codice del ticket non trovato';

$hesklang['select_priority']='Per favore scegli la priorità';
$hesklang['ticket_not_found']='Ticket non trovato! Assicurati di aver inserito il codice corretto!';
$hesklang['no_selected']='Nessun ticket selezionato, nessuna modifica da apportare';
$hesklang['id_not_valid']='Questo non è un ID valido';
$hesklang['enter_id']='Per favore inserisci il codice del ticket';
$hesklang['enter_name']='Per favore inserisci il nome del cliente';
$hesklang['enter_date']='Per favore inserisci la data che vuoi cercare';
$hesklang['date_not_valid']='La data inserita non è valida, il formato deve essere <b>AAAA-MM-GG</b>.';
$hesklang['enter_subject']='Per favore inserisci l\'oggetto del ticket';
$hesklang['invalid_search']='Azione di ricerca non valida';
$hesklang['choose_cat_ren']='Per favore seleziona la categoria da rinominare';
$hesklang['cat_ren_name']='Per favore scrivi il nome della nuova categoria';
$hesklang['cat_not_found']='Categoria non trovata';
$hesklang['enter_cat_name']='Per favore inserisci il nome della categoria';
$hesklang['no_cat_id']='Nessun ID di categoria';
$hesklang['cant_del_default_cat']='Non puoi cancellare la categoria predefinita, puoi solo rinominarla';
$hesklang['no_valid_id']='ID utente non valido';
$hesklang['user_not_found']='Utente non trovato';
$hesklang['enter_real_name']='Per favore inserisci il vero nome dell\'utente';
$hesklang['enter_valid_email']='Per favore inserisci un indirizzo email valido';
$hesklang['enter_username']='Per favore inserisci il tuo username (login)';
$hesklang['asign_one_cat']='Per favore assegna l\'utente ad almeno una categoria!';

$hesklang['confirm_user_pass']='Per favore conferma la password';
$hesklang['passwords_not_same']='Le due password inserite non sono uguali!';
$hesklang['cant_del_admin']='Non puoi cancellare l\'amministratore predefinito!';
$hesklang['cant_del_own']='Non puoi cancellare l\'account con cui sei loggato!';
$hesklang['enter_your_name']='Per favore inserisci il tuo nome';
$hesklang['enter_message']='Per favore inserisci il tuo messaggio';
$hesklang['sel_app_cat']='Per favore seleziona la categoria appropriata';
$hesklang['sel_app_priority']='Per faovre seleziona la priorità del tuo messaggio';
$hesklang['enter_ticket_subject']='Per favore inserisci l\'oggetto del tuo ticket';
$hesklang['user_not_found_nothing_edit']='Utente non trovato o niente da modificare';


// ADMIN PANEL
$hesklang['administrator']='Amministratore';
$hesklang['login']='Login';
$hesklang['user']='Utente';
$hesklang['username']='Username';
$hesklang['pass']='Password';
$hesklang['confirm_pass']='Conferma password';
$hesklang['logged_out']='Disconnesso';
$hesklang['logout']='Esci';
$hesklang['logout_success']='Disconnessione effettuata con successo!';
$hesklang['click_login']='Clicca qui per il login';
$hesklang['back']='Indietro';
$hesklang['displaying_pages']='<b>%d</b> ticket visualizzati. Pagine:';
$hesklang['trackID']='Codice del ticket';
$hesklang['timestamp']='Timestamp';
$hesklang['name']='Nome';
$hesklang['subject']='Oggetto';
$hesklang['status']='Stato';
$hesklang['priority']='Priorità';

$hesklang['open_action']='Apri ticket'; // Open ACTION
$hesklang['close']='Chiuso'; // Closed ticket STATUS
$hesklang['any_status']='Qualsiasi stato';
$hesklang['high']='Alta';
$hesklang['medium']='Media';
$hesklang['low']='Bassa';
$hesklang['del_selected']='Cancella i ticket selezionati';
$hesklang['manage_cat']='Gestione categorie';
$hesklang['profile']='Il tuo profilo';
$hesklang['show_tickets']='Mostra ticket';
$hesklang['sort_by']='Ordina per';
$hesklang['date_posted']='Data di invio';
$hesklang['category']='Categoria';
$hesklang['any_cat']='Qualsiasi categoria';
$hesklang['order']='Ordine';
$hesklang['ascending']='crescente';
$hesklang['descending']='decrescente';
$hesklang['display']='Visualizza';
$hesklang['tickets_page']='ticket per pagina';
$hesklang['find_ticket']='Cerca ticket';
$hesklang['yyyy_mm_dd']='AAAA-MM-GG';
$hesklang['results_page']='risultati per pagina';
$hesklang['opened']='aperto'; // The ticket has been OPENED

$hesklang['ticket']='Ticket';
$hesklang['tickets']='Ticket';
$hesklang['ticket_been']='Questo ticket è stato';
$hesklang['view_ticket']='Visualizza ticket';
$hesklang['open_tickets']='Ticket aperti';
$hesklang['remove_statement']='Rimuovi la dichiarazione &quot;Powered by&quot;';
$hesklang['click_info']='Clicca qui per maggiori informazioni';
$hesklang['reply_added']='Aggiunta risposta';

$hesklang['ticket_marked']='Questo ticket è stato selezionato';
$hesklang['ticket_status']='Stato del ticket';
$hesklang['replies']='Risposte';
$hesklang['date']='Data';
$hesklang['email']='Email';
$hesklang['ip']='IP';
$hesklang['message']='Messaggio';
$hesklang['add_reply']='Aggiungi risposta';

$hesklang['change_priority']='Cambia la priorità a';
$hesklang['attach_sign']='Allega firma';
$hesklang['profile_settings']='Impostazioni profilo';
$hesklang['submit_reply']='Invia risposta';
$hesklang['support_panel']='Pannello di Supporto';
$hesklang['ticket_trackID']='Codice del ticket';
$hesklang['c2c']='Clicca qui per continuare';
$hesklang['tickets_deleted']='Ticket cancellati';
$hesklang['num_tickets_deleted']='Sono stati cancellati <b>%d</b> ticket';
$hesklang['found_num_tickets']='Trovati <b>%d</b> ticket. Pagine:';
$hesklang['confirm_del_cat']='Sei sicuro di voler rimuovere questa categoria?';
$hesklang['cat_intro']='Qui puoi gestire le tue categorie. Le categorie servono a differenziare
i ticket a seconda degli argomenti trattati (per esempio &quot;Vendite&quot;,
&quot;Problemi hardware&quot;,&quot;Problemi PHP/MySQL&quot; etc) e per
assegnare gli utenti alle categorie (per esempio un addetto alle vendite può solo vedere i ticket
inviati alla categoria &quot;Vendite&quot;)';



$hesklang['cat_name']='Nome categoria';
$hesklang['remove']='Elimina';
$hesklang['add_cat']='Aggiungi nuova categoria';
$hesklang['max_chars']='max 40 caratteri';
$hesklang['create_cat']='Crea categoria';
$hesklang['ren_cat']='Rinomina categoria';
$hesklang['to']='a';
$hesklang['cat_added']='Categoria aggiunta';
$hesklang['cat_name_added']='La categoria %s è stata aggiunta correttamente';
$hesklang['cat_renamed']='Categoria rinominata';
$hesklang['cat_renamed_to']='La categoria selezionata è stata rinominata con successo in';
$hesklang['cat_removed']='Categoria rimossa';
$hesklang['cat_removed_db']='La categoria selezionata è stata rimossa correttamente dal database';
$hesklang['sure_remove_user']='Sei sicuro di voler rimuovere questo utente?';
$hesklang['manage_users']='Gestione utenti';
$hesklang['users_intro']='Qui puoi gestire gli utenti che hanno accesso al pannello di amministrazione e
che possono rispondere ai ticket. Gli amministratori possono visualizzare/modificare i ticket in qualsiasi categoria e avere accesso
a tutte le funzioni del pannello di amministrazione (gestione utenti, gestione categorie, ...) mentre
gli altri utenti possono solo visualizzare e rispondere ai ticket presenti nelle categorie a cui vengono assegnati';




$hesklang['yes']='SI';
$hesklang['no']='NO';
$hesklang['edit']='Modifica';
$hesklang['add_user']='Aggiungi nuovo utente';
$hesklang['req_marked_with']='I campi obbligatori sono evidenziati con';
$hesklang['real_name']='Nome reale';

$hesklang['sign_extra']='Il codice HTML non è ammesso. I link saranno cliccabili';
$hesklang['create_user']='Crea utente';
$hesklang['editing_user']='Modifica utente';
$hesklang['user_added']='Utente aggiunto';
$hesklang['user_added_success']='Il nuovo utente %s con la password %s è stato aggiunto correttamente';


$hesklang['user_removed']='Utente rimosso';
$hesklang['sel_user_removed']='L\'utente selezionato è stato rimosso con successo dal database';
$hesklang['profile_for']='Profilo di';
$hesklang['new_pass']='Nuova password';
$hesklang['update_profile']='Aggiorna profilo';
$hesklang['notify_new_posts']='Avvisami quando sono presenti nuovi ticket o risposte nelle mie categorie';
$hesklang['profile_updated']='Profilo aggiornato';
$hesklang['profile_updated_success']='Il tuo profilo è stato aggiornato con successo';
$hesklang['view_profile']='Visualizza profilo';

$hesklang['new_ticket_submitted']='Inviato nuovo ticket di supporto';
$hesklang['user_profile_updated_success']='Il profilo di questo utente è stato aggiornato correttamente';
$hesklang['printer_friendly']='Versione stampabile';
$hesklang['end_ticket']='--- Fine del ticket ---';

                                                
// CUSTOMER INTERFACE
$hesklang['your_ticket_been']='Il tuo ticket è stato';

$hesklang['submit_ticket']='Invia un ticket';
$hesklang['sub_ticket']='Invia ticket';
$hesklang['before_submit']='Prima di effettuare l\'invio assicurati che:';
$hesklang['all_info_in']='Tutte le informazioni necessarie siano state inserite';
$hesklang['all_error_free']='Tutte le informazioni siano corrette e prive di errori';
$hesklang['we_have']='Abbiamo registrato';
$hesklang['recorded_ip']='come tuo indirizzo IP';
$hesklang['recorded_time']='data e ora della tua richiesta di invio';
$hesklang['save_changes']='Salva modifiche';
$hesklang['reply_submitted']='Risposta inviata';
$hesklang['reply_submitted_success']='La tua risposta a questo ticket è stata inviata correttamente';
$hesklang['view_your_ticket']='Visualizza il tuo ticket';
$hesklang['ticket_submitted']='Ticket inviato';
$hesklang['ticket_submitted_success']='Il tuo ticket è stato inviato correttamente! Ticket ID';
$hesklang['your_ticket']='Il tuo ticket';


// ALL FILES DDED IN HESK VERSION UNTIL VERSION 2.3 
$hesklang['check_updates']='Assicurati di aver sempre installato l\'ultima versione di Hesk!';
$hesklang['check4updates']='Controlla aggiornamenti';
$hesklang['open']='Nuovo';
$hesklang['wait_reply']='In attesa risposta staff';
$hesklang['wait_staff_reply']='In attesa risposta staff';
$hesklang['wait_cust_reply']='In attesa feedback cliente';
$hesklang['replied']='Risposto';
$hesklang['closed']='Risolto';
$hesklang['last_replier']='Ultimo a rispondere';
$hesklang['staff']='Staff';
$hesklang['customer']='Cliente';
$hesklang['close_selected']='Marca i ticket selezionati come Risolti';
$hesklang['execute']='Esegui';
$hesklang['saved_replies']='Risposte predefinite';
$hesklang['manage_saved']='Risposte predefinite';
$hesklang['manage_intro']='Qui puoi aggiungere e gestire le risposte predefinite. Questo sono risposte utilizzate comunemente per tutti gli utenti. Dovresti usare le risposte predefinite per evitare di scrivere ogni volta la stessa risposta per utenti differenti.';


$hesklang['no_saved']='Nessuna risposta predefinita';
$hesklang['delete_saved']='Sei sicuro di voler cancellare questa risposta predefinita?';
$hesklang['new_saved']='Aggiungi o Modifica una risposta predefinita';
$hesklang['canned_add']='Crea una nuova risposta predefinita';
$hesklang['canned_edit']='Modifica la risposta predefinita selezionata';
$hesklang['saved_title']='Titolo';
$hesklang['save_reply']='Salva risposta';
$hesklang['saved']='Risposta salvata';
$hesklang['your_saved']='La risposta predefinita è stata salvata per utilizzo futuro';
$hesklang['ent_saved_title']='Per favore inserisci il titolo della risposta';
$hesklang['ent_saved_msg']='Per favore inserisci il messaggio di risposta';
$hesklang['saved_removed']='Risposta predefinita rimossa';
$hesklang['saved_rem_full']='Le risposte predefinite selezionate sono state rimosse dal database';
$hesklang['clip_alt']='Questo messaggio ha allegati';
$hesklang['attachments']='Allegati';
$hesklang['fill_all']='Campo obbligatorio mancante';
$hesklang['file_too_large']='Il tuo file %s è troppo grande';

$hesklang['created_on']='Creato il';
$hesklang['tickets_closed']='Ticket chiusi';
$hesklang['num_tickets_closed']='<b>%d</b> ticket sono stati chiusi';
$hesklang['select_saved']='Seleziona una risposta predefinita';
$hesklang['select_empty']='Seleziona / Vuoto';
$hesklang['insert_special']='Inserisci tag speciale (sostituirà le informazioni del cliente)';
$hesklang['move_to_catgory']='Sposta il ticket in';
$hesklang['move']='Sposta';
$hesklang['moved']='Ticket spostato';
$hesklang['moved_to']='Questo ticket è stato spostato nella nuova categoria';
$hesklang['url']='URL';
$hesklang['all_not_closed']='Tutti i non chiusi';
$hesklang['chg_all']='Cambia tutto';
$hesklang['settings']='Impostazioni';
$hesklang['settings_intro']='Usa questo strumento per configurare il tuo help desk. Per maggiori informazioni sulle impostazioni clicca il simbolo di aiuto o fai riferimento al file readme.html';

$hesklang['all_req']='Tutti i campi (eccetto quelli disabilitati) sono obbligatori!';
$hesklang['wbst_title']='Nome Sito Web';
$hesklang['wbst_url']='URL Sito Web';
$hesklang['email_sup']='Email supporto';

$hesklang['max_listings']='Visualizzazioni per pagina';
$hesklang['print_size']='Dimensione font stampa';
$hesklang['debug_mode']='Modalità debug';
$hesklang['on']='SI';
$hesklang['off']='NO';
$hesklang['use_secimg']='Usa immagine anti-SPAM';
$hesklang['secimg_no']='Non disponibile';
$hesklang['attach_use']='Usa allegati';
$hesklang['attach_num']='Numero allegati per post';
$hesklang['attach_type']='Tipi di file permessi';
$hesklang['place_after']='Dopo il messaggio';
$hesklang['place_before']='Prima del messaggio';
$hesklang['custom_f']='Campo personalizzato';
$hesklang['custom_u']='Usa questo campo';
$hesklang['custom_n']='Nome del campo';
$hesklang['custom_l']='Lunghezza massima (car.)';

$hesklang['db_host']='Host Database';
$hesklang['db_name']='Nome Database';
$hesklang['db_user']='Username Database';
$hesklang['db_pass']='Password Database';
$hesklang['err_sname']='Per favore inserisci il titolo del tuo sito web';
$hesklang['err_surl']='Per favore inserisci l\'URL del tuo sito web. Assicurati che sia valido (che inizi cioè con http:// o https://)';

$hesklang['err_wmmail']='Per favore inserisci un indirizzo email valido per il webmaster';
$hesklang['err_nomail']='Per favore inserisci un indirizzo email valido per noreply';
$hesklang['err_htitle']='Per favore inserisci il titolo del tuo sistema di supporto';
$hesklang['err_hurl']='Per favore inserisci l\'URL della cartella Hesk. Assicurati che sia valido (che inizi cioè con http:// o https://)';
$hesklang['err_spath']='Per favore inserisci il percorso di sistema (root, server) alla cartella Hesk';
$hesklang['err_lang']='Per favore seleziona la lingua per Hesk';


$hesklang['err_max']='Inserisci il massimo numero di visualizzazioni per pagina';
$hesklang['err_psize']='Inserisci la dimensione del font di stampa';
$hesklang['err_dbhost']='Per favore inserisci l\'host del database MySQL';
$hesklang['err_dbname']='Per favore inserisci il nome del database MySQL';
$hesklang['err_dbuser']='Per favore inserisci lo username del database MySQL';
$hesklang['err_dbpass']='Per favore inserisci la password del database MySQL';

$hesklang['err_dbsele']='Non posso connettermi al database MySQL, per favore ricontrolla il NOME del database';
$hesklang['err_custname']='Inserisci un nome per i campi opzionali selezionati';
$hesklang['err_openset']='Impossibile aprire <b>hesk_settings.inc.php</b> per la scrittura. Fai CHMOD con questo file a 666 (rw-rw-rw-)';
$hesklang['set_saved']='Impostazioni salvate';
$hesklang['set_were_saved']='Le tue impostazioni sono state salvate correttamente';
$hesklang['sec_img']='Immagine di sicurezza';
$hesklang['sec_miss']='Per favore inserisci il numero di sicurezza';
$hesklang['sec_wrng']='Numero di sicurezza errato';
$hesklang['submit_problems']='Per favore torna indietro e correggi i problemi elencati';
$hesklang['cat_order']='Ordinamento categorie';
$hesklang['reply_order']='Ordinamento risposte predefinite';
$hesklang['move_up']='Sposta su';
$hesklang['move_dn']='Sposta giù';
$hesklang['cat_move_id']='ID categoria mancante';
$hesklang['reply_move_id']='ID risposta predefinita mancante';
$hesklang['forgot_tid']='Hai dimenticato il codice del ticket?';
$hesklang['tid_send']='Inviami il codice del ticket';
$hesklang['tid_not_found']='Non sono stati trovati ticket per il tuo indirizzo email';
$hesklang['tid_sent']='Codice del ticket inviato';
$hesklang['tid_sent2']='Una e-mail con i dettagli dei tuoi ticket è stata inviata al tuo indirizzo';

$hesklang['check_spambox']='In caso di non ricezione della email assicurati di controllare anche nella cartella  SPAM/Junk!';
$hesklang['reply_not_found']='Risposta predefinita non trovata';
$hesklang['exists']='Esiste';
$hesklang['no_exists']='Non esiste';
$hesklang['writable']='Scrivibile';
$hesklang['not_writable']='Non scrivibile';
$hesklang['disabled']='disabilitato';
$hesklang['e_settings']='Non sarai in grado di salvare le impostazioni fino a che questo file non sarà scrivibile dallo script. Per favore fai riferimento al file readme per maggiori informazioni!';
$hesklang['e_attdir']='Non sarai in grado di salvare allegati le impostazioni fino a che questa cartella non sarà scrivibile dallo script. Per favore fai riferimento al file readme per maggiori informazioni!';


$hesklang['e_save_settings']='Impossibile salvare le impostazioni poiché il file <b>hesk_settings.inc.php</b> non è scrivibile dallo script.';
$hesklang['e_attach']='Disabilitati perchè la cartella <b>attachments</b> non è scrivibile dallo script.';
$hesklang['go']='Vai';
// ADDED OR CHANGED IN VERSION 2.0
$hesklang['v']='Versione HESK version';
$hesklang['check_status']='Verifica Stato';
$hesklang['sub_support']='Invia un ticket';
$hesklang['open_ticket']='Invia una nuova richiesta a un dipartimento';
$hesklang['view_existing']='Visualizza ticket esistenti';
$hesklang['vet']='Visualizza ticket già inviati';
$hesklang['enter_user']='Per favore inserisci il tuo username';
$hesklang['remember_user']='Ricorda il mio username';
$hesklang['wrong_user']='Username errato';
$hesklang['no_permission']='Non hai i permessi per eseguire questa azione, fai il login con un account autorizzato ad eseguirla.';
$hesklang['tickets_on_pages']='Numero di ticket: %d | Numero di pagine: %d'; // First %d is replaced with number of tickets, second %d with number of pages
$hesklang['jump_page']=' | Salta alla pagina:';
$hesklang['no_tickets_open']='Non ci sono ticket non risolti';
$hesklang['no_tickets_crit']='Non ci sono ticket che corrispondono ai criteri scelti';
$hesklang['confirm_execute']='Sei sicuro di voler continuare?';
$hesklang['legend']='Legenda';
$hesklang['main_page']='Home';
$hesklang['menu_users']='Utenti';
$hesklang['menu_cat']='Categorie';
$hesklang['menu_profile']='Profilo';

$hesklang['menu_kb']='Knowledgebase'; // Admin MENU item
$hesklang['kb_text']='Knowledgebase'; // Item visible to customers
$hesklang['viewkb']='Visualizza l\'intera Knowledgebase';
$hesklang['kb']='Gestione Knowledgebase';
$hesklang['kb_intro']='La Knowledgebase è una raccolta di risposte alle domande più frequenti (FAQ) e di articoli che forniscono risorse d\'aiuto ai clienti.
Una knowledgebase ricca e ben scritta può ridurre drasticamente il numero di richieste di supporto, con conseguente risparmio di tempo. Puoi organizzare gli articoli in categorie


e sotto categorie.'; // Description in ADMIN panel
$hesklang['kb_is']='La Knowledgebase è una raccolta categorizzata di risposte alle domande più frequenti (FAQ) e di articoli. Puoi leggere gli articoli in questa categoria o selezionare una sotto categoria di tuo interesse.'; // Description for CUSTOMERS

$hesklang['new_kb_art']='Nuovo articolo di knowledgebase';
$hesklang['kb_cat']='Categoria';
$hesklang['kb_subject']='Oggetto';
$hesklang['kb_content']='Contenuti';
$hesklang['kb_type']='Tipo';
$hesklang['kb_published']='Pubblicato';
$hesklang['kb_published2']='L\'articolo è visualizzabile da tutti nella knowledgebase.';
$hesklang['kb_private']='Privato';
$hesklang['kb_private2']='Gli articoli privati possono essere letti solo dallo staff.';
$hesklang['kb_draft']='Bozza';
$hesklang['kb_draft2']='L\'articolo è salvato ma non ancora pubblicato. Può essere letto solo dallo staff<br /> che ha il permesso di gestire gli articoli del knowledgebase.';

$hesklang['kb_links']='<i><span class="notice"><b>Attenzione!</b></span><br />Inserici codice valido senza i tag &lt;head&gt; e &lt;body&gt;, solo il contenuto!</i>';
$hesklang['kb_ehtml']='Questo è codice HTML (Inserirò solo codice valido (X)HTML)';
$hesklang['kb_dhtml']='Questo è testo semplice (i link saranno cliccabili)';
$hesklang['kb_save']='Salva articolo';
$hesklang['kb_e_subj']='Inserire l\'oggetto dell\'articolo!';
$hesklang['kb_e_cont']='Scrivi i contenuti dell\'articolo!';
$hesklang['kb_art_added']='Articolo aggiunto';
$hesklang['your_kb_added']='Un nuovo articolo del knowledgebase è stato agggiunto';
$hesklang['kb_art_deleted']='Articolo cancellato';
$hesklang['your_kb_deleted']='L\'articolo del knowledgebase selezionato è stato cancellato';
$hesklang['kb_art_mod']='Articolo modificato';
$hesklang['your_kb_mod']='Le tue modifiche all\'articolo selezionato sono state salvate correttamente';

$hesklang['kb_cat_new']='Nuova categoria del knowledgebase';
$hesklang['kb_cat_parent']='Categoria principale';
$hesklang['kb_cat_sub']='Sotto Categorie';
$hesklang['kb_cat_title']='Titolo Categoria';
$hesklang['kb_cat_published']='La categoria è visualizzabile da tutti nel knowledgebase';
$hesklang['kb_cat_private']='La categoria può essere letta solo dallo staff';
$hesklang['kb_cat_add']='Aggiungi categoria';
$hesklang['kb_cat_e_title']='Inserisci il titolo della categoria!';
$hesklang['kb_cat_added']='Categoria aggiunta';
$hesklang['kb_cat_added2']='Una nuova categoria è stata aggiunta con successo al konwledgebase';

$hesklang['kb_cat_man']='Gestione categorie knowledgebase';
$hesklang['kb_cat_edit']='Modifica dettagli categoria';
$hesklang['kb_cat_inv']='Categoria non valida';
$hesklang['kb_cat_art']='Articoli in questa categoria';
$hesklang['kb_p_art']='+ Articolo';
$hesklang['kb_p_art2']='aggiungi un nuovo articolo alla categoria selezionata';
$hesklang['kb_add_art']='Aggiungi articolo';
$hesklang['kb_p_cat']='+ Categoria';
$hesklang['kb_p_cat2']="crea una nuova sotto categoria nella categoria selezionata";

$hesklang['kb_add_cat']='Aggiungi categoria';
$hesklang['kb_p_man']='Gestione';
$hesklang['kb_p_man2']='gestione della categoria selezionata (modifica, cancellazione, gestione articoli).';
$hesklang['kb_main']='La categoria principale del knowledgebase non può essere cancellata o spostata';
$hesklang['kb_no_art']='Non ci sono articoli in questa categoria';
$hesklang['author']='Autore';
$hesklang['views']='Visite';
$hesklang['delete']='Cancella';
$hesklang['rating']='Valutazione';
$hesklang['votes']='Voti';
$hesklang['kb_rated']='Articolo valutato %s/5.0';
$hesklang['kb_not_rated']='Articolo non ancora valutato';
$hesklang['del_art']='Sei sicuro di voler cancellare l\'articolo selezionato?';
$hesklang['kb_art_id']='ID articolo mancante o non valido!';
$hesklang['kb_art_edit']='Modifica articolo';
$hesklang['revhist']='Cronologia Modifiche';


$hesklang['kb_order']='Ordine';
$hesklang['kb_delcat']='Sei sicuro di voler cancellare questa categoria?';
$hesklang['kb_cat_mod']='Categoria modificata';
$hesklang['your_cat_mod']='Le modifiche apportate alla categoria selezionata sono state salvate con successo';

$hesklang['kb_cat_del']='Categoria del knowledgebase cancellata';
$hesklang['kb_cat_dlt']='La categoria del knowledgebase selezionata è stata cancellata';
$hesklang['allowed_cat']='Categorie';
$hesklang['allow_feat']='Funzionalità';
$hesklang['can_view_tickets']='Visualizza ticket';
$hesklang['can_reply_tickets']='Risponde ai ticket';
$hesklang['can_assign_tickets']='Assegna i ticket';
$hesklang['can_del_tickets']='Cancella i ticket';
$hesklang['can_edit_tickets']='Modifica le risposte dei ticket';
$hesklang['can_change_cat']='Cambia la categoria del ticket';
$hesklang['can_man_kb']='Gestione knowledgebase';
$hesklang['can_man_users']='Gestione utenti';
$hesklang['can_man_cat']='Gestione categorie';
$hesklang['can_man_canned']='Gestione risposte predefinite';
$hesklang['can_man_settings']='Gestione impostazioni help desk';
$hesklang['can_del_notes']='Cancella tutte le note dei ticket';
$hesklang['dan']='gli utenti possono cancellare solo le loro note dei ticket, seleziona questo solo se si vuole consentire a questo utente di cancellare le note di altri utenti';

$hesklang['in_all_cat']='solo nelle categorie consentite';
$hesklang['admin_can']='(accesso a tutte le funzionalità e categorie)';
$hesklang['staff_can']='(puoi limitare funzionalità e categorie)';
$hesklang['asign_one_feat']='Per favore assegna almeno una caratteristica a questo utente!';
$hesklang['na_view_tickets']='Non sei autorizzato a visualizzare i ticket';
$hesklang['support_notice']='Spiacente, questa sezione può essere nascosta solo se si acquista una licenza HESK!';

$hesklang['rart']='Ti è stato d\'aiuto questo articolo?';
$hesklang['r']='Questa risposta ti è stata d\'aiuto?';
$hesklang['tyr']='Grazie per la valutazione';
$hesklang['cw']='Chiudi Finestra';
$hesklang['cw2']='Chiudi finestra e invia ticket';
$hesklang['rh']='Valuta come <i>utile</i>';
$hesklang['rnh']='Valuta come <i>non utile</i>';
$hesklang['ar']='Già valutato';
$hesklang['rated']='Valutazione utenti %s/5.0 (%s voti)';
$hesklang['not_rated']='Nessuna valutazione dagli utenti';
$hesklang['rdis']='La valutazione è stata disabilitata';
$hesklang['kbdis']='La Knowledgebase è disabilitata';
$hesklang['kbpart']='Spiacente, non hai i permessi necessari per accedere a questo articolo';

$hesklang['popart']='Articoli Top della Knowledgebase:';
$hesklang['latart']='Ultimi articoli nella Knowledgebase:';
$hesklang['m']='Più argomenti';
$hesklang['ac']='Articoli in questa categoria:';
$hesklang['noa']='Non ci sono ancora articoli';
$hesklang['noac']='Non ci sono ancora articoli in questa categoria';
$hesklang['dta']='Data inserimento';
$hesklang['ad']='Dettagli articolo';
$hesklang['aid']='ID Articolo';
$hesklang['as']='Soluzione';
$hesklang['search']='Cerca';
$hesklang['sr']='Cerca risultati';
$hesklang['nosr']='Nessun articolo corrispondente trovato. Prova a cercare nella knowledgebase o invia un nuovo ticket di supporto.';

$hesklang['rv']='Resetta visualizzazioni';
$hesklang['rr']='Resetta voti (valutazioni)';
$hesklang['opt']='Opzioni';
$hesklang['delcat']='Cancella categoria';
$hesklang['move1']='Sposta articoli nella categoria principale';
$hesklang['move2']='Cancella articoli in questa categoria';
$hesklang['sc']='Articoli suggeriti della knowledgebase';
$hesklang['not']='Ticket';

$hesklang['graph']='Grafico';
$hesklang['lu']='Elenco degli username';
$hesklang['aclose']='Chiudi automaticamente ticket';
$hesklang['aclose2']='giorni dopo l\'ultima risposta dello staff';
$hesklang['s_ucrt']='Riapri ticket';
$hesklang['urate']='Rispondi alle valutazioni';
$hesklang['hesk_url']='URL dell\'Help desk';
$hesklang['hesk_title']='Titolo Help desk';
$hesklang['server_time']='Offset del time server';
$hesklang['t_h']='ore';
$hesklang['cid']='Case Tracking ID';
$hesklang['t_m']='minuti';
$hesklang['day']='Ora legale';
$hesklang['tfor']='Formato ora';
$hesklang['prefix']='Prefisso tabella';
$hesklang['s_kbs']='Abilita ricerca nella KB';

$hesklang['s_kbr']='Abilita valutazione della KB';
$hesklang['s_maxsr']='Max risultati ricerca';
$hesklang['s_suggest']='Suggerisci articoli della KB';
$hesklang['s_spop']='Mostra articoli più popolari';
$hesklang['s_slat']='Mostra ultimi articoli';
$hesklang['s_onin']='sulla <a href="../" target="_blank">pagina principale</a> dell\'help desk';
$hesklang['s_onkb']='sulla <a href="../knowledgebase.php" target="_blank">pagina principale</a> della Knowledgebase';
$hesklang['s_scol']='Categorie per riga';
$hesklang['s_ptxt']='Lunghezza anteprima articolo';
$hesklang['s_psubart']='Articoli delle sotto categorie';
$hesklang['enable']='Abilita';
$hesklang['s_type']='Tipo';
$hesklang['custom_r']='Obbligatorio';
$hesklang['custom_place']='Posizione';
$hesklang['custom_use']='Campi personalizzati';
$hesklang['stf']='Campo testo';
$hesklang['stb']='Casella di testo grande';
$hesklang['srb']='Pulsante di Opzione';
$hesklang['ssb']='Menù a Tendina'; 
$hesklang['db']='Database';
$hesklang['hd']='Impostazioni Help desk';
$hesklang['gs']='Impostazioni generali';
$hesklang['cwin']='Chiudi Finestra';
$hesklang['defw']='Valore Predefinito';
$hesklang['ok']='OK';
$hesklang['ns']='Queste sono le opzioni disponibili per questo campo personalizzato. Per salvare le modifiche clicca sul pulsante <b>OK</b> e <b>Salva modifiche</b> nella pagina delle impostazioni amministrative!';

$hesklang['rows']='Righe (altezza)';
$hesklang['cols']='Colonne (larghezza)';
$hesklang['opt2']='Opzioni per questo Pulsante di Opzione, inserire una opzione per riga (ogni riga creerà un nuovo Pulsante di Opzione tra cui scegliere). Devi inserire almeno due opzioni!';
$hesklang['opt3']='Opzioni per questo Menù a Tendina, inserire una opzione per riga (ogni riga sarà una voce che potrà essere scelta dai tuoi clienti). Devi inserire almeno due opzioni!';


$hesklang['atl2']='Inserire almeno due opzioni (una per riga)!';
$hesklang['notes']='Note';
$hesklang['addnote']='+ Aggiungi nota';
$hesklang['noteby']='Nota di';
$hesklang['delnote']='Cancella nota';
$hesklang['noteerr']='Nota già cancellata o parametri errati';
$hesklang['s']='Invia';
$hesklang['nhid']='Le note non sono visibili ai clienti!';
$hesklang['delt']='Cancella questo post';
$hesklang['edtt']='Modifica post';
$hesklang['edt1']='Post modificato';
$hesklang['edt2']='Le modifiche al post selezionato sono state salvate';
$hesklang['dele']='Cancella questo ticket';
$hesklang['repd']='Post cancellato';
$hesklang['repl']='Il post selezionato è stato cancellato';
$hesklang['tickets_found']='Risultati ricerca';
$hesklang['al']='Link ad Amministrazione';
$hesklang['ap']='Vai al Pannello Amministrativo';
$hesklang['dap']='Visualizza un link al pannello amministrativo dalla <a href="../" target="_blank">pagina principale</a> dell\'help desk';
$hesklang['q_miss']='Per favore rispondi alla domanda anti-SPAM';
$hesklang['use_q']='Usa domanda anti-SPAM';
$hesklang['q_q']='-&gt; Domanda (il codice HTML è <font class="success">ammesso</font>)';
$hesklang['q_a']='-&gt; Risposta';
$hesklang['err_qask'] = 'Inserisci una domanda anti-SPAM';
$hesklang['err_qans'] = 'Inserisci la risposta alla domanda anti-SPAM';
$hesklang['genq'] = 'Genera una domanda casuale';
// Added or modified in version 2.1
$hesklang['amo']='Aggiungi altro';
$hesklang['delatt']='Cancellare l\'allegato selezionato?';
$hesklang['kb_att_rem']='L\'allegato selezionato è stato rimosso';
$hesklang['inv_att_id']='ID allegato non valido!';
$hesklang['scb']='Casella di Controllo';
$hesklang['opt4']='Opzioni per questa Casella di Controllo, inserisci una opzione per riga. Ogni riga sarà una voce che potrà essere scelta dai tuoi clienti, è possibile fare una scelta multipla. Devi inserire almeno due opzioni!';

$hesklang['autologin']='Connettimi automaticamente ad ogni visita';
$hesklang['just_user']='Ricorda solo il mio username';
$hesklang['nothx']='No, grazie';
$hesklang['pinfo']='Informazioni del profilo';
$hesklang['sig']='Firma';
$hesklang['pref']='Preferenze';
$hesklang['aftrep']='Dopo aver risposto a un ticket';
$hesklang['showtic']='Mostra il ticket a cui ho appena risposto';
$hesklang['gomain']='Ritorna alla pagina principale amministrativa';
$hesklang['shownext']='Apri il prossimo ticket che attende la mia risposta (se non ce ne sono va alla pagina principale amministrativa)';
$hesklang['rssn']='Sto mostrando il prossimo ticket che necessita della tua attenzione';
$hesklang['mrep']='Sostituisci il messaggio esistente';
$hesklang['madd']='Aggiungi in basso';
$hesklang['priv']='Le categorie private e gli articoli visibili solo allo staff sono indicati con *';

$hesklang['inve']='File email non valido';
$hesklang['emfm']='File email mancante';
$hesklang['hesk_lang']='Lingua predefinita';
$hesklang['s_mlang']='Lingue multiple';
$hesklang['s_mlange']='Abilitalo solo se puoi fornire supporto in tutte le lingue installate!';

$hesklang['s_inl']='Cartella test per la lingua';
$hesklang['s_inle']='Faccio il testo delle cartelle per le lingue valide. Solo le lingue che passano tutti i test sono installate correttamente. Per installare una lingua e aiutarti con gli errori visualizza il file <b>readme.html</b>!';

$hesklang['alo']='Permetti login automatico';
$hesklang['chol']='Lingua preferita';
$hesklang['mmdl']='Imposta questa come mia Lingua predefinita';
$hesklang['warn']='ATTENZIONE';
$hesklang['dmod']='La modalità debug è abilitata. Assicurati di disabilitare la modalità debug nelle impostazioni una volta che Hesk è installato e funziona correttamente';

$hesklang['kb_spar']='La categoria non può essere la categoria principale!';
$hesklang['mysql_root']='La tua password MySQL è vuota, sei sicuro di volerti connettere con lo user di root? Questo è un rischio di sicurezza!';

$hesklang['chg']='Modifica';
$hesklang['chpri']='Priorità modificata';
$hesklang['chpri2']='La priorità del ticket è stata cambiata a %s';
$hesklang['selcan']='Seleziona la risposta predefinita che desideri modificare';

$hesklang['q_wrng']='Risposta anti-SPAM errata';
$hesklang['cndupl']='Hai già una categoria con questo nome. Scegli un nome univoco per ogni categoria.';
$hesklang['wsel']='Seleziona il campo per cui vuoi effettuare la ricerca';


// Added or modified in version 2.2


$hesklang['eto']='Richiesta non valida';
$hesklang['id']='ID';
$hesklang['geco']='Genera Link Diretto';
$hesklang['genl']='Link diretto alla categoria';
$hesklang['genl2']='Usa questo link per preselezionare una categoria nel form &quot;Invia un ticket&quot;.';

$hesklang['exa']='Esempi';

$hesklang['small']='Box Piccolo';
$hesklang['large']='Box Grande';
$hesklang['cpri']='Priorità cliente';
$hesklang['owner']='Proprietario';
$hesklang['unas']='Non Assegnato';
$hesklang['assi']='Assegna';
$hesklang['asst']='Assegna a';
$hesklang['asst2']='Assegna questo ticket a';
$hesklang['asss']='Assegnati questo ticket';
$hesklang['asss2']='Assegna questo ticket a me stesso';
$hesklang['can_assign_self']='Può assegnare i ticket a se stesso';
$hesklang['can_assign_others']='Può assegnare i ticket ad altri';

$hesklang['can_view_ass_others']='Può visualizzare i ticket assegnati ad altri';
$hesklang['unoa']='L\'utente selezionato non ha accesso a questa categoria';

$hesklang['tasi']='Assegnato al Proprietario';
$hesklang['tasy']='Questo ticket è stato assegnato a te';
$hesklang['taso']='Questo ticket è stato assegnato all\'utente selezionato';
$hesklang['tasy2']='Assegnato a me';
$hesklang['taso2']='Assegnato ad altro elemento dello staff';
$hesklang['nose']='Scegli il nuovo Proprietario';
$hesklang['onasc']='Questo proprietario non ha accesso alla categoria selezionata.';

$hesklang['tunasi']='Ticket Non Assegnati';
$hesklang['tunasi2']='Il ticket è senza un proprietario ed è pronto per essere assegnato nuovamente';

$hesklang['note']='Nota';
$hesklang['success']='Successo';
$hesklang['nyt']='Questo ticket è assegnato a';
$hesklang['noch']='Non sono state apportate modifiche';
$hesklang['orch']='L\'ordine di visualizzazione è stato modificato';
$hesklang['rfm']='Mancano alcune informazioni obbligatorie:';
$hesklang['repl0']='Autorizzazioni insufficienti per eseguire questa operazione';

$hesklang['repl1']='Questo post non esiste';
$hesklang['reports']='Rapporti';
$hesklang['reports_intro']='La sezione di report ti consente di generare numerose relazioni e visualizzare le statistiche sui ticket in un intervallo di date specifico.';

$hesklang['refi']='Reimposta il modulo dati';
$hesklang['dich']='Annulla le Modifiche';
$hesklang['dire']='Visualizza Rapporto';
$hesklang['m1']='Gennaio';
$hesklang['m2']='Febbraio';
$hesklang['m3']='Marzo';
$hesklang['m4']='Aprile';
$hesklang['m5']='Maggio';
$hesklang['m6']='Giugno';
$hesklang['m7']='Luglio';
$hesklang['m8']='Agosto';
$hesklang['m9']='Settembre';
$hesklang['m10']='Ottobre';
$hesklang['m11']='Novembre';
$hesklang['m12']='Dicembre';
$hesklang['d1']='Lunedì';
$hesklang['d2']='Martedì';
$hesklang['d3']='Mercoledì';
$hesklang['d4']='Giovedì';
$hesklang['d5']='Venerdì';
$hesklang['d6']='Sabato';
$hesklang['d0']='Domenica';
$hesklang['mo']='Lu';
$hesklang['tu']='Ma';
$hesklang['we']='Me';
$hesklang['th']='Gi';
$hesklang['fr']='Ve';
$hesklang['sa']='Sa';
$hesklang['su']='Do';
$hesklang['from']='Da';
$hesklang['cinv']='Data non valida';
$hesklang['cinv2']='Il formato accettato è mm/dd/yyyy';
$hesklang['cinm']='Il valore del mese non è valido';
$hesklang['cinm2']='L\'intervallo consentito è';
$hesklang['cind']='Il valore del giorno non è valido';
$hesklang['cind2']='L\'intervallo consentito per il mese selezionato è';
$hesklang['month']='Mese';
$hesklang['ocal']='Apri Calendario';
$hesklang['ca01']='Anno Precedente';
$hesklang['ca02']='Mese Precedente';
$hesklang['ca03']='Mese Seccessivo';
$hesklang['ca04']='Anno Successivo';
$hesklang['ca05']='Chiudi Calendario';
$hesklang['cdr']='Scegli l\'intervallo delle date:';
$hesklang['crt']='Scegli il tipo di rapporto:';
$hesklang['r1']='Oggi';
$hesklang['r2']='Ieri';
$hesklang['r3']='Questo mese';
$hesklang['r4']='Il mese scorso';
$hesklang['r5']='Ultimi 30 giorni';
$hesklang['r6']='Questa settimana (Lu-Do)';
$hesklang['r7']='La settimana scorsa (Lu-Do)';
$hesklang['r8']='Questa settimana commerciale (Lu-Ve)';
$hesklang['r9']='La settimana scorsa commerciale (Lu-Ve)';
$hesklang['r10']='Quest\'anno';
$hesklang['r11']='L\'anno scorso';
$hesklang['r12']='Tutte le date';
$hesklang['datetofrom']='&quot;Data Da&quot; non può essere maggiore di &quot;Data A&quot;. Le date sono state invertite.';
$hesklang['t1']='Ticket per giorno';
$hesklang['t2']='Ticket per mese';
$hesklang['t3']='Ticket per utente';
$hesklang['t4']='Ticket per categoria';
$hesklang['ticass']='Ticket assegnati';
$hesklang['ticall']='Risposte ai ticket';
$hesklang['totals']='Totali';
$hesklang['all']='Tutto';
$hesklang['atik']='Nuovi ticket';
$hesklang['kbca']='Hai già una categoria nella knowledgebase con questo nome.';

$hesklang['menu_msg']='Posta';
$hesklang['menu_can']='Predefinite';
$hesklang['m_from']='Da:';
$hesklang['m_to']='A:';
$hesklang['m_sub']='Oggetto:';
$hesklang['m_re']='Re:'; // Mail reply subject prefix, like "Re: Original subject"
$hesklang['m_fwd']='Fwd:'; // Mail forward subject prefix, like "Fwd: Original subject"
$hesklang['m_h']='Messaggi privati';
$hesklang['m_intro']='Usa i messaggi privati per inviare messaggi veloci ad altri membri dello staff all\'interno di HESK.';

$hesklang['e_udel']='(Utente cancellato)';
$hesklang['new_mail']='Nuovo messaggio privato';
$hesklang['m_send']='Invia messaggio';
$hesklang['m_rec']='Seleziona il destinatario del messaggio';
$hesklang['m_inr']='Destinatario del messaggio non valido';
$hesklang['m_esu']='Inserisci oggetto del messaggio privato';
$hesklang['m_pms']='Il tuo messaggio privato è stato inviato';
$hesklang['inbox']='Posta In Arrivo';
$hesklang['outbox']='Posta Inviata';
$hesklang['m_new']='Nuovo Messaggio';
$hesklang['pg']='Mostra pagina';
$hesklang['npm']='Nessun messaggio privato in questa cartella.';
$hesklang['m_ena']='Non hai il permesso per leggere questo messaggio.';

$hesklang['mau']='Segna come non letto';
$hesklang['mo1']='Segna i messaggi selezionati come letti';
$hesklang['mo2']='Segna i messaggi selezionati come non letti';
$hesklang['mo3']='Elimina i messaggi selezionati';
$hesklang['delm']='Elimina questo messaggio';
$hesklang['e_tid']='Errore durante la generazione di un Ticket ID univoco, per favore prova a inviare il modulo di richiesta tra qualche minuto.';
$hesklang['smmr']='I messaggi selezionati sono stati contrassegnati come letti';
$hesklang['smmu']='I messaggi selezionati sono stati contrassegnati come non letti';



$hesklang['smdl']='I messaggi selezionati sono stati eliminati';
$hesklang['show']='Visualizza';
$hesklang['s_my']='Assegnato a me';
$hesklang['s_ot']='Assegnato ad altri';
$hesklang['s_un']='Ticket non assegnati';
$hesklang['s_for']='Cerca per';
$hesklang['s_in']='Cerca in';
$hesklang['s_incl']='Cerca tra';
$hesklang['find_ticket_by']='Trova un ticket';
$hesklang['e_nose']='Non è stato selezionato nessuno stato di assegnazione, mostro tutti i ticket.';
$hesklang['fsq']='Inserisci i termini della tua ricerca';
$hesklang['topen']='Aperto'; // Not-resolved tickets
$hesklang['nms']='Nessun messaggio selezionato, niente da modificare';
$hesklang['tlo']='Blocca ticket';
$hesklang['tul']='Sblocca ticket';
$hesklang['loc']='Bloccato';
$hesklang['isloc']='I clienti non possono rispondere o riaprire i ticket bloccati. Quando un ticket è bloccato, viene marcato come risolto.';

$hesklang['tlock']='Il Ticket è stato bloccato';
$hesklang['tunlock']='Il Ticket è stato sbloccato';
$hesklang['tislock']='Questo ticket è stato bloccato, il cliente non sarà in grado di inviare una risposta.';

$hesklang['tislock2']='Questo ticket è stato bloccato, non puoi inviare una risposta.';
$hesklang['nsfo']='Non sono stati trovati articoli rilevanti.';
$hesklang['elocked']='Questo ticket è stato bloccato o eliminato.';








$hesklang['nti']='+ Nuovo ticket';
$hesklang['nti2']='Inserisci un nuovo ticket';
$hesklang['nti3']='Utilizza questo modulo per creare un nuovo ticket per conto di un cliente. Inserisci le informazioni del <i>cliente</i> nel modulo (nome del cliente, email del cliente, ...) e NON il tuo nome! Il ticket verrà creato come se fosse stato inserito dal cliente stesso.';

$hesklang['addop']='Opzioni';
$hesklang['seno']='Inviare email di notifica al cliente';
$hesklang['otas']='Mostra il ticket dopo l\'inserimento';
$hesklang['notn']='Notifiche';
$hesklang['nomw']='L\'Help Desk ti invierà una notifica via email quando:';

$hesklang['nwts']='Viene inserito un nuovo ticket con proprietario:';
$hesklang['ncrt']='Il cliente risponde a un ticket con proprietario:';
$hesklang['ntam']='Mi viene assegnato un ticket';
$hesklang['npms']='Mi viene inviato un messaggio privato';
$hesklang['support_remove']='Sono stati investiti tempo ed energie nello sviluppo di HESK. Supporta HESK, acquista una licenza che rimuoverà inoltre il link dei credits <i>Powered by Help Desk Software HESK</i> dal tuo helpdesk';
$hesklang['ycvtao']='Non sei autorizzato a visualizzare i ticket assegnati ad altri';

$hesklang['password_not_valid']='La password deve essere lunga almeno 5 caratteri';
$hesklang['lkbs']='Caricamento dei suggerimenti dalla knowledgebase...';
$hesklang['auto']='(automaticamente)'; // 
// Added or modified in version 2.3
$hesklang['unknown']='Sconosciuto';
$hesklang['pcer']='Per favore correggi i seguenti errori:';
$hesklang['seqid']='Numero Ticket';
$hesklang['close_action']='Marca come Risolto'; // Close ACTION
$hesklang['archived']='Taggato';
$hesklang['archived2']='Ticket Taggato';
$hesklang['add_archive']='Tagga questo ticket';
$hesklang['add_archive_quick']='Tagga i ticket selezionati';
$hesklang['remove_archive']='Rimuovi il tag da questo ticket';
$hesklang['remove_archive_quick']='Rimuovi i tag dai ticket selezionati';
$hesklang['added_archive']='Ticket Taggato';
$hesklang['removed_archive']='Rimosso Tag dal Ticket';
$hesklang['added2archive']='Il Ticket è stato taggato';
$hesklang['removedfromarchive']='E\' stato rimosso il tag dal Ticket';
$hesklang['num_tickets_tag']='<b>%d</b> ticket sono stati taggati';
$hesklang['num_tickets_untag']='A <b>%d</b> ticket è stato rimosso il tag';
$hesklang['can_add_archive']='Può taggare i ticket';
$hesklang['disp_only_archived']='Solo ticket taggati';
$hesklang['search_only_archived']='Solo ticket taggati';
$hesklang['critical']=' * Critica * ';




/* START abbreviatons used in "last updated" column */
$hesklang['abbr']['year']='a';
$hesklang['abbr']['month']='m';
$hesklang['abbr']['week']='set';
$hesklang['abbr']['day']='g';
$hesklang['abbr']['hour']='h';
$hesklang['abbr']['minute']='min';
$hesklang['abbr']['second']='sec';
/* END abberviations*/
$hesklang['cnsm']='Non è possibile inviare il messaggio a:';
$hesklang['yhbb']='Sei stato bloccato dal sistema per %s minuti poiché hai effettuato troppi tentativi di login falliti.';

$hesklang['pwdst']='Robustezza della Password';
$hesklang['tid_mail']='Nessun problema! Inserisci il tuo <b>Indirizzo Email</b> e ti invieremo il codice del tuo ticket:';

$hesklang['rem_email']='Ricorda il mio indirizzo email';
$hesklang['eytid']='Inserisci il tuo codice del ticket.';
$hesklang['enmdb']='L\'indirizzo email che hai inserito non corrisponde a quello associato a questo ticket ID.';

$hesklang['confemail']='Conferma l\'indirizzo email';
$hesklang['confemail2']='Per favore conferma il tuo indirizzo email';
$hesklang['confemaile']='I due indirizzi email non sono identici';
$hesklang['taso3']='Assegnato a:';
$hesklang['sec_enter']='Digita il numero che vedi nell\'immagine in basso.';
$hesklang['reload']='Ricarica immagine';  // Reload image
$hesklang['verify_q']='Prevenzione SPAM:'; // For anti-spam question
$hesklang['verify_i']='Prevenzione SPAM:'; // For anti-spam image (captcha)
$hesklang['admin_login']='Login Staff';
$hesklang['vrfy']='Test superato';
$hesklang['last_update']='Aggiornato';
$hesklang['cot']='Non forzare i ticket con stato Critico in testa';
$hesklang['def']='Rendi questa la mia vista di default';
$hesklang['gbou']='Questi ticket sono <b>Non Assegnati</b>:';
$hesklang['gbom']='Ticket assegnati a <b>me</b>:';
$hesklang['gboo']='Ticket assegnati a <b>%s</b>:';
$hesklang['select']=' - - Clicca per Scegliere - - ';
$hesklang['chngstatus']='Cambia stato in ';
$hesklang['perat']='%s di tutti i ticket'; // will change to "23% of all tickets"
$hesklang['viewart']='Visualziza questo articolo';
$hesklang['chdp']='Per favore cambia la password predefinita nella tua pagina del <a href="profile.php">Profilo</a>!';
$hesklang['chdp2']='Cambia la tua password, stai utlizzando quella predefinita!';
$hesklang['security']='Sicurezza';
$hesklang['kb_i_art']='Nuovo Articolo';
$hesklang['kb_i_art2']='Inserisci un Articolo';
$hesklang['kb_i_cat']='Nuova Categoria';
$hesklang['kb_i_cat2']='Inserisci una Categoria';
$hesklang['gopr']='Visualizza la Knowledgebase';
$hesklang['kbstruct']='Struttura della Knowledgebase';
$hesklang['cancel']='Annulla';
$hesklang['sh']='Nascondi messaggio';
$hesklang['goodkb']='Come scrivere buoni articoli per la Knowledgebase?';
$hesklang['catset']='Impostazioni Categoria';
$hesklang['inpr']='Seleziona la nuova Priorità';
$hesklang['incat']='Seleziona la nuova Categoria';
$hesklang['instat']='Seleziona il nuovo Stato';
$hesklang['tsst']='Lo stato del Ticket è stato impostato a %s';
$hesklang['aass']='Auto-assegnazione';
$hesklang['aaon']='Auto-assegnazione dei ticket abilitata (clicca per disabilitarla)';
$hesklang['aaoff']='Auto-assegnazione dei ticket disabilitata (clicca per abilitarla)';
$hesklang['uaaon']='L\'auto-assegnazione è stata abilitata per l\'utente selezionato';
$hesklang['uaaoff']='L\'auto-assegnazione è stata disabilitata per l\'utente selezionato';
$hesklang['taasy']='Questo ticket è stato assegnato automaticamente a te';
$hesklang['can_view_unassigned']='Può visualizzare i ticket non assegnati';
$hesklang['ycovtay']='Puoi vedere solo i ticket assegnati a te';
$hesklang['in_progress']='In Lavorazione';
$hesklang['on_hold']='In attesa cliente';
$hesklang['import_kb']='Importa questo ticket in un articolo della Knowledgebase';
$hesklang['import']='Stai importando un <i>ticket privato</i> in un <i>articolo pubblico</i>.<br /><br />Assicurati di aver cancellato ogni informazione di tipo privato o sensibile dall\'oggetto e dal corpo del messaggio!';

$hesklang['tab_1']='Generale';
$hesklang['tab_2']='Help Desk';
$hesklang['tab_3']='Knowledgebase';
$hesklang['tab_4']='Campi Personalizzati';
$hesklang['tab_5']='Miscellanea';
$hesklang['disable']='Disabilitato';
$hesklang['dat']='Data &amp; Ora';
$hesklang['lgs']='Lingua';
$hesklang['onc']='SI - Clienti';
$hesklang['ons']='SI - Tutti';
$hesklang['viewvtic']='Visualizzazione ticket';
$hesklang['reqetv']='Email obbligatoria per la visualizzazione del ticket';
$hesklang['banlim']='Limite tentativi di login';
$hesklang['banmin']='Tempo di Sospensione (minuti)';
$hesklang['subnot']='Invia avviso';
$hesklang['subnot2']='Mostra avvisi ai clienti che inviano i ticket';
$hesklang['eseqid']='ID sequenziali';
$hesklang['sconfe']='Conferma email';
$hesklang['saass']='Ticket auto-assegnati';
$hesklang['swyse']='Editor WYSIWYG';
$hesklang['hrts']='Valuta HESK';
$hesklang['hrts2']='Mostra il link a \'Valuta questo script\' nel pannello amministrativo';
$hesklang['emlpipe']='Email piping';
$hesklang['emlsend']='Invio Email';
$hesklang['emlsend2']='Invia email usando';
$hesklang['phpmail']='PHP mail()';
$hesklang['smtp']='Server SMTP';
$hesklang['smtph']='Host SMTP';
$hesklang['smtpp']='Porta SMTP';
$hesklang['smtpu']='Username SMTP';
$hesklang['smtpw']='Password SMTP';
$hesklang['smtpt']='Timeout SMTP';
$hesklang['other']='Altro';
$hesklang['features']='Funzionalità';
$hesklang['can_view_online']='Può vedere online gli altri membri dello staff';
$hesklang['online']='Online';
$hesklang['offline']='Offline';
$hesklang['onlinep']='Utenti Online'; // For display
$hesklang['sonline']='Utenti Online'; // For settings page
$hesklang['sonline2']='Mostra utenti online. Limite (minuti):'; // For settings page
$hesklang['gb']='Raggruppa per';
$hesklang['dg']='Non raggruppare';
$hesklang['err_dpi']='Il database %s non contienen tutte le tabelle HESK con il prefisso %s, non sono state salvate le modifiche.';

$hesklang['err_dpi2']='Tabelle non trovate:';
$hesklang['sme']='Errore SMTP';
$hesklang['scl']='Log connessione SMTP';
$hesklang['dnl']='Download';
$hesklang['dela']='Cancella questo allegato';
$hesklang['pda']='Vuoi cancellare in modo definitivo questo allegato?';


$hesklang['mopt']='Più opzioni';
$hesklang['lopt']='Meno opzioni';
$hesklang['meml']='Email multiple';
$hesklang['meml2']='Permetti ai clienti di inserire indirizzi email multipli.';




// FILES ADDED OR MODIFIED IN version 2.4
$hesklang['catd']='(categoria cancellata)';
$hesklang['noopen']='Non è stato trovato alcun ticket aperto con questo indirizzo email.';
$hesklang['maxopen']='Hai raggiunto il numero massimo di ticket aperti (%d di %d).
 Attendi cortesemente che i tuoi ticket attuali siano chiusi prima di aprire nuovi tickets.';

 $hesklang['ntnote']='Qualcuno ha aggiunto una nota nel ticket assegnato';
$hesklang['cat_public']='Questa categoria è PUBBLICA (clicca per renderla privata)';
$hesklang['cat_private']='Questa categoria è PRIVATA (clicca per renderla pubblica)';
$hesklang['cat_aa']='Assegna ticket automaticamente in questa categoria.';
$hesklang['cat_type']='Rendi questa categoria privata (solo lo staff può selezionarla).';
$hesklang['caaon']='L\'assegnazione automatica è stata abilitata per la categoria selezionata';
$hesklang['caaoff']='L\'assegnazione automatica è stata disabilitata per la categoria selezionata';


$hesklang['cpub']='Tipo di categoria cambiata in PUBBLICA';
$hesklang['cpriv']='Tipo di categoria cambiata in PRIVATA';
$hesklang['cpric']='I clienti non possono selezionare categorie private, solo lo staff può accedere!';
$hesklang['user_aa']='Assegna ticket in automatico a questo utente.';
$hesklang['attach_size']='Limite dimensione allegati (KB)';
$hesklang['B']='B';
$hesklang['kB']='KB';
$hesklang['MB']='MB';
$hesklang['GB']='GB';
$hesklang['bytes']='bytes';
$hesklang['kilobytes']='kilobytes';
$hesklang['megabytes']='megabytes';
$hesklang['gigabytes']='gigabytes';
$hesklang['smtpssl']='Protocollo SSL';
$hesklang['smtptls']='Protocollo TLS';
$hesklang['oo']='Apri solo';
$hesklang['ool']='Elenca soltanto i ticket aperti in &quot;Forgot tracking ID&quot; email';
$hesklang['mop']='Numero massimo di ticket aperti';
$hesklang['rord']='Ordine di risposta';
$hesklang['newbot']='Ultima risposta in fondo';
$hesklang['newtop']='Ultima risposta in cima';
$hesklang['ford']='Form di risposta';
$hesklang['formbot']='Mostra form in fondo';
$hesklang['formtop']='Mostra form in cima';
$hesklang['mysqlv']='Versione MySQL';
$hesklang['phpv']='Version PHP';
$hesklang['csrt']='Ora locale del server:';
$hesklang['listp']='Elenca gli articoli privati';
$hesklang['listd']='Elenca le bozze degli articoli';
$hesklang['artp']='Articoli privati';
$hesklang['artd']='Bozze degli articoli';
$hesklang['kb_no_part']='Nessun articolo privato nel knowledgebase.';
$hesklang['kb_no_dart']='Nessun bozza di articolo nel knowledgebase.';
$hesklang['attpri']='Non hai accesso a questo allegato.';
$hesklang['can_merge_tickets']='Unisci tickets';
$hesklang['mer_selected']='Unisci i ticket selezionati';
$hesklang['merged']='I ticket selezionati sono stati uniti in un ticket.';
$hesklang['merge_err']='C\'è stato un problema nell\'unione dei ticket:';
$hesklang['merr1']='seleziona almeno due tickets.';
$hesklang['merr2']='il ticket cercato non è stato trovato.';
$hesklang['merr3']='ticket in una categoria dove non puoi accedere.';
$hesklang['tme']='Il ticket %s è stato unito con questo ticket (%s).';
$hesklang['tme1']='Il ticket %s è stato unito con il ticket %s';
$hesklang['tme2']='Per accedere al ticket %s inserisci il tuo indirizzo email.';
$hesklang['eyou']='Utilizza la pagina del tuo profilo per modificare le tue impostazioni.';
$hesklang['npea']='Non hai i permessi per modificare questo utente.';

$hesklang['duplicate_user']='Hai già un utente con questo username! Scegli uno username univoco per ogni utente.';
$hesklang['kw']='Keywords';
$hesklang['kw1']='(opzionale - separato da spazio, virgola o nuova linea)';
$hesklang['type_not_allowed']='Il file (%s) non è di un formato valido';// Files ending with .exe are not accepted (test.exe)
$hesklang['unread']='Il cliente non ha ancora letto questa risposta.';
$hesklang['sticky']='Metti questo articolo &quot;in evidenza&quot;';
$hesklang['stickyon']='Cambia l\'articolo a &quot;in evidenza&quot;';
$hesklang['stickyoff']='Cambia l\'articolo a &quot;Normale&quot;';
$hesklang['ason']='Articolo selezionato come &quot;in evidenza&quot;';
$hesklang['asoff']='Articolo selezionato come &quot;Normale&quot;';
$hesklang['ts']='Tempo di lavorazione';
$hesklang['start']='Inizio / Stop';
$hesklang['reset']='Reset';
$hesklang['save']='Salva';
$hesklang['hh']='Ore';
$hesklang['mm']='Minuti';
$hesklang['ss']='Secondi';
$hesklang['thist']='Cronologia dello stato dei ticket';
$hesklang['twu']='Il tempo di lavorazione del ticket è stato aggiornato.';





$hesklang['autoss']='Fai partire automaticamente il timer quando apro un ticket';
$hesklang['ful']='Limiti di upload del file';
$hesklang['ufl']='Puoi caricare i file terminanti con:';
$hesklang['nat']='Numero massimo di allegati:';
$hesklang['mfs']='Dimensione massima per allegato:';
$hesklang['lps']='Le tue preferenze di lingua sono state salvate';
$hesklang['sav']='Mostra le visite dell\'articolo';
$hesklang['sad']='Mostra la data dell\'articolo';
$hesklang['epd']='MESSAGGIO DA HESK: l\'email piping è disabilitato. Abilitalo nelle impostazioni amministrative!';


$hesklang['pfd']='[HESK] POP3 FETCHING E\' DISABILITATO NELLE IMPOSTAZIONI';
$hesklang['pem']='[Piped email]'; // Default subject of piped tickets without subject
$hesklang['pde']='[Cliente]'; // Default customer name for piped tickets without name
$hesklang['tab_6']='Email';
$hesklang['pop3']='POP3 Fetching';
$hesklang['pop3h']='POP3 Host';
$hesklang['pop3p']='POP3 Port';
$hesklang['pop3tls']='Protocollo TLS';
$hesklang['pop3u']='POP3 Username';
$hesklang['pop3w']='POP3 Password';
$hesklang['pop3e']='POP3 errore';
$hesklang['pop3log']='POP3 connection log';
$hesklang['mysqltest']='Test connessione MySQL ';
$hesklang['smtptest']='Test connessione SMTP ';
$hesklang['pop3test']='Test connessione POP3 ';
$hesklang['contest']='Sto testando la connessione... attendi...';
$hesklang['conok']='Connessione OK!';
$hesklang['conokn']='Tuttavia, se il tuo server richiede username e password, l\'email non verrà inviata!';
$hesklang['saving']='Sto salvando le impostazioni, attendi...';
$hesklang['sns']='Tutte le impostazioni sono state salvate, ma SMTP è stato disabilitato poiché è fallito il testo per SMTP.'; 

$hesklang['loops']='Email Loops';
$hesklang['looph']='Max Hits';
$hesklang['loopt']='Timeframe';
$hesklang['didum']='Vuoi dire %s?'; // Did you mean someone@gmail.com?
$hesklang['yfix']='Si, sistemalo';
$hesklang['nole']='No, lascia come è';
$hesklang['sconfe2']='Mostra un campo &quot;Conferma email&quot; nel form di invio del ticket';
$hesklang['oln']='Vecchio nome:';
$hesklang['nen']='Nuovo nome:';
$hesklang['use_form_below']='<i>Utilizza il form seguente per inviare un ticket. I campi obbligatori sono evidenziati con</i>';
$hesklang['esf']='Non posso inviare la notifica via email.';
$hesklang['qrr']='(la risposta quotata è stata rimossa)';
$hesklang['remqr']='Strip quoted reply';
$hesklang['remqr2']='Cancella la risposta quotata dall\'email del cliente';
$hesklang['suge']='Detect email typos';
$hesklang['epro']='Email providers';
$hesklang['email_noreply']='Email per No reply';
$hesklang['email_name']='&quot;From:&quot; name';
$hesklang['vscl']='Server configuration limits';
$hesklang['fnuscphp']='Il caricamento del file è fallito, riprova con un file più piccolo o senza allegato.';
$hesklang['redv']='Resetta la vista di default';
$hesklang['fatte1']='Le tue impostazione per &quot;Numero di post&quot; è maggiore di quanto il server permette!';
$hesklang['fatte2']='Il tuo file allegato è più grande di quanto il server permette!';
$hesklang['fatte3']='Il tuo server non permette post troppi lunghi, cerca di ridurre il numero di allegati o le dimensioni dei file!';

$hesklang['embed']='File incorporati';
$hesklang['embed2']='Salva i files incorporati come allegati';
$hesklang['emrem']='(immagine rimossa)';
$hesklang['hdemo']='(NASCOSTA NEL DEMO)';
$hesklang['ddemo']='Spiacente questa funziona è disabilitata in modalità DEMO!';
$hesklang['sdemo']='I salvataggi sono disabilitati in modalità DEMO';
$hesklang['hud']='HESK è aggiornato';
$hesklang['hnw']='Aggiornamento disponibile';
$hesklang['getup']='Aggiorna HESK';
$hesklang['updates']='Aggiornamenti';
$hesklang['updates2']='Controlla automaticamente gli aggiornamenti di HESK.';


// Added or modified in version 2.5.0
$hesklang['emp']='Il vostro PHP non ha il supporto MySQL attivo (estensione mysqli richiesta)';

$hesklang['attdel']='Questo file è stato eliminato dal server e non è più disponibile per il download';
$hesklang['cannot_move_tmp']='Impossibile spostare il file nella cartella allegati';
$hesklang['dsen']='Non inviare email di notifica di tale risposta al cliente';

$hesklang['attrem']='* Alcuni file allegati sono stati rimossi *';
$hesklang['attnum']='Numero massimo raggiunto: %s'; // %s will show folder name
$hesklang['attsiz']='File troppo grande: %s'; // %s will show folder name
$hesklang['atttyp']='Estensione non ammessa: %s'; // %s will show folder name
$hesklang['adf']='Cartella Amministrazione';
$hesklang['atf']='Cartella Allegati';
$hesklang['err_adf']='La cartella amministrazione selezionata(%s) non esiste!'; // %s will show folder name
$hesklang['err_atf']='La cartella allegati selezionata(%s) non esiste!'; // %s will show folder name
$hesklang['err_atr']='La cartella allegati selezionata(%s) non è scrivibile!'; // %s will show folder name
$hesklang['fatt']='Allegati a questo messaggio:';
$hesklang['wrepo']='Scrivere un messaggio dopo aver ripaerto il ticket.';
$hesklang['ktool']='&raquo; Strumenti Knowledgebase';
$hesklang['uac']='Verifica e aggiorna contatore visualizzazione articolo';

$hesklang['acv']='Il contatore articolo è stato verificato';
$hesklang['xyz']='numero degli articoli pubblici e privati salvati nella categoria.';

$hesklang['reports_tab']='Eseguire report'; // Tab title
$hesklang['crt']='Tipo di report';
$hesklang['can_run_reports']='Eseguire report(suoi)';
$hesklang['can_run_reports_full']='Eseguire report(tutti)';
$hesklang['can_export']='Può esportare i ticket';
$hesklang['roo']='<i>(solo i ticket assegnati a te sono inclusi nel report)</i>';
$hesklang['shu']='Link breve';
$hesklang['export']='Esporta tickets'; // Tab title
$hesklang['export_btn']='Esporta tickets'; // Button title
$hesklang['export_intro']='Questo strumento consente di esportare i tickets in un foglio XML che può essere aperto in Excel.';
$hesklang['stte']='Seleziona ticket da esportare';
$hesklang['dtrg']='Periodo';
$hesklang['sequentially']='In sequenza'; // Order tickets: Sequentially
$hesklang['ede']='Impossibile creare la directory di esportazione, si prega di creare manualmente una cartella chiamata<b>export</b> all\'interno della vostra cartella allegati e assicurarsi che sia scrivibile da PHP(in Linux CHMOD it to 777 - rwxrwxrwx).';
$hesklang['eef']='Impossibile creare il file di esportazione, senza il permesso di scrivere all\'interno della directory di esportazione.';
$hesklang['inite']='Inizializzazione esportazione';
$hesklang['gXML']='Generando XML file';
$hesklang['nrow']='Numero di righe esportate: %d'; // %d will show number of rows exported
$hesklang['cZIP']='Compressione file in archivio Zip';
$hesklang['eZIP']='Errore nel creare l\'archivio Zip';
$hesklang['fZIP']='Compressione file terminata';
$hesklang['pmem']='utilizzo della memoria di picco: %.2f Mb'; // %.2f will be replaced with number of Mb used
$hesklang['ch2d']='&raquo; CLICCA QUI PER SCARICARE IL FILE DI ESPORTAZIONE &laquo;';
$hesklang['n2ex']='Nessun biglietto trovato corrispondente ai criteri di ricerca, nulla da esportare!';

$hesklang['sp']='Prevenzione SPAM'; // For settings page
$hesklang['sit']='-&gt; Tipo di immagine';
$hesklang['sis']='Immagine semplice';




$hesklang['pop3keep']='Conservare una copia';
$hesklang['err_dbconn']='Impossibile connettersi al database MySQL utilizzando le informazioni fornite!';
$hesklang['s_inle']='Test della cartella della lingua per le lingue valide. Solo le lingue che passano tutti i test siano installati correttamente.';

$hesklang['ask']='Aiuto di ricerca:';
$hesklang['beta']='(TEST VERSION)';
$hesklang['maxpost']='Probabilmente avete tentato di presentare più dati di quanti questo server ne accetta.<br /><br />Si prega di provare a inviare il modulo di nuovo con allegati inferiori o non presenti.';


// --> Ticket history log
// Unless otherwise specified, first %s will be replaced with date and second with name/username
$hesklang['thist1']='<li class="smaller">%s | spostato alla categoria %s da %s</li>'; // %s = date, new category, user making change
$hesklang['thist2']='<li class="smaller">%s | assegnato a %s da %s</li>'; // %s = date, assigned user, user making change
$hesklang['thist3']='<li class="smaller">%s | chiuso da %s</li>';
$hesklang['thist4']='<li class="smaller">%s | aperto da %s</li>';
$hesklang['thist5']='<li class="smaller">%s | bloccato da %s</li>';
$hesklang['thist6']='<li class="smaller">%s | sbloccato da %s</li>';
$hesklang['thist7']='<li class="smaller">%s | ticket creato da %s</li>';
$hesklang['thist8']='<li class="smaller">%s | priorità modificata in %s da %s</li>'; // %s = date,new priority, user making change
$hesklang['thist9']='<li class="smaller">%s | stato modificato in %s da %s</li>'; // %s = date, new status, user making change
$hesklang['thist10']='<li class="smaller">%s | automaticamente assegnato a %s</li>';
$hesklang['thist11']='<li class="smaller">%s | inviato da email piping</li>';
$hesklang['thist12']='<li class="smaller">%s | allegati %s rimossi da %s</li>'; // %s = date, deleted attachment, user making change
$hesklang['thist13']='<li class="smaller">%s | unito con ticket %s da %s</li>'; // %s = date, merged ticket ID, user making change
$hesklang['thist14']='<li class="smaller">%s | tempo di lavorazione aggiornato in %s da %s</li>'; // %s = date, new time worked, user making change
$hesklang['thist15']='<li class="smaller">%s | inviato da %s</li>';
$hesklang['thist16']='<li class="smaller">%s | inviato da POP3 fetching</li>';

// --> Knowledgebase articles log
// First %s will be replaced with date and second with user making changes
$hesklang['revision1']='<li class="smaller">%s | inviato da %s</li>';
$hesklang['revision2']='<li class="smaller">%s | modificato da %s</li>';

// --> Text used by ReCaptcha
$hesklang['visual_challenge']='Verifica Visuale';
$hesklang['audio_challenge']='Verifica Audio';
$hesklang['refresh_btn']='Nuovo codice';
$hesklang['instructions_visual']='Riscrivi le due parole:';
$hesklang['instructions_context']='Scrivi le parole visualizzate nel box:';
$hesklang['instructions_audio']='Scrivi quello che senti:';
$hesklang['help_btn']='Aiuto';
$hesklang['play_again']='Riproduci di nuovo audio';
$hesklang['cant_hear_this']='Scarica audio come MP3';
$hesklang['incorrect_try_again']='Verifica errata. Prova ancora.';
$hesklang['image_alt_text']='reCAPTCHA immagine';
$hesklang['recaptcha_error']='Risposta antispam errata, si prega di riprovare.';
// Added or modified in version 2.5.3
$hesklang['close_this_ticket']='Chiudi questo ticket';


// Added or modified in version 2.6.0
$hesklang['ms01']='Gen';
$hesklang['ms02']='Feb';
$hesklang['ms03']='Mar';
$hesklang['ms04']='Apr';
$hesklang['ms05']='Mag';
$hesklang['ms06']='Giu';
$hesklang['ms07']='Lug';
$hesklang['ms08']='Ago';
$hesklang['ms09']='Set';
$hesklang['ms10']='Ott';
$hesklang['ms11']='Nov';
$hesklang['ms12']='Dic';
$hesklang['sdf']='Formato della data (inserito)';
$hesklang['lcf']='Formato della data (aggiornato)';
$hesklang['lcf0']='Breve descrizione';
$hesklang['lcf1']='Data e ora';
$hesklang['lcf2']='HESK style';
$hesklang['ticket_tpl']='Modelli Ticket';
$hesklang['can_man_ticket_tpl']='Gestisce i modelli Ticket'; // Permission title
$hesklang['ticket_tpl_man']='Gestisci i modelli Ticket'; // Page/link title
$hesklang['ticket_tpl_intro']='Creare e modificare i modelli di ticket che è possibile utilizzare come risposta rapida predefinita da interfaccia di amministrazione.';
$hesklang['no_ticket_tpl']='Nessun modello ticket predefinito';
$hesklang['ticket_tpl_title']='Titolo';
$hesklang['delete_tpl']='Siete sicuri di voler eliminare questi modelli ticket?';
$hesklang['new_ticket_tpl']='Aggiungi o modifica modello ticket';
$hesklang['ticket_tpl_add']='Crea un nuovo modello ticket';
$hesklang['ticket_tpl_edit']='Modifica i modelli ticket selezionati';
$hesklang['save_ticket_tpl']='Salva modello ticket';
$hesklang['ticket_tpl_saved']='Il vostro modello ticket è stato salvato per usi futuri';
$hesklang['ticket_tpl_removed']='I modelli ticket selezionati sono stati rimossi dal database';
$hesklang['ticket_tpl_not_found']='Modello ticket non trovato';
$hesklang['sel_ticket_tpl']='Selezionare il modello ticket che si desidera modificare';
$hesklang['ent_ticket_tpl_title']='Si prega di inserire un titolo modello';
$hesklang['ent_ticket_tpl_msg']='Si prega di inserire il messaggio del ticket predefinito';
$hesklang['ticket_tpl_id']='ID del template modello non trovato';
$hesklang['select_ticket_tpl']='Selezionare un modello di ticket';
$hesklang['list_tickets_cat']='Mostrare tutti i ticket in questa categoria';
$hesklang['def_msg']='[Nessun messaggio]';
$hesklang['emlreqmsg']='Messaggio richiesto';
$hesklang['emlreqmsg2']='Ignora i messaggi piped/fetched email privi di messaggio';
$hesklang['relart']='Articoli correlati'; // Title of related articles box
$hesklang['s_relart']='Articoli correlati'; // On settings page
$hesklang['tab_7']='Lista Ticket';
$hesklang['fitl']='Campi nella lista ticket';
$hesklang['submitted']='Inviati';
$hesklang['clickemail']='Visualizza';
$hesklang['set_pri_to']='Imposta priorità a:'; // Action below the ticket list
$hesklang['pri_set_to']='Priorità impostata a:';
$hesklang['cat_pri']='La priorità categoria verrà utilizzata quando i clienti non sono autorizzati a selezionare la priorità e un ticket viene inviato dall\'interfaccia cliente.';
$hesklang['cat_pri_info']='I vostri clienti possono selezionare la priorità, così verranno ignorate le categorie prioritarie.<br /><br />To use category priority instead, turn OFF the following feature in HESK settings:';
$hesklang['def_pri']='Categorie prioritarie:';
$hesklang['ch_cat_pri']='Imposta categorie prioritarie';
$hesklang['cat_pri_ch']='La categoria prioritaria è stata impostata su:';
$hesklang['err_dbversion']='Versione %s MySQL troppo antica:'; // %s will be replaced with MySQL version
$hesklang['signature_max']='Firma (massimo 1000 caratteri)';
$hesklang['signature_long']='La firma è troppo lunga! Si prega di ridurre a 1000 caratteri.';
$hesklang['ip_whois']='IP whois';
$hesklang['ednote']='Modifica messaggio della nota';
$hesklang['ednote2']='Messaggio della nota salvato';
$hesklang['perm_deny']='Permesso negato';
$hesklang['mis_note']='ID nota non trovato';
$hesklang['no_note']='Nota con questo ID non trovata';
$hesklang['sacl']='Salva e prosegui più tardi';
$hesklang['reply_saved']='La vostra risposta è stata salvata per proseguire più tardi.';
$hesklang['submit_as']='Invia come:';
$hesklang['sasc']='Invia come risposta dal cliente';
$hesklang['creb']='Risposta del cliente inserita da:';
$hesklang['show_select']='Mostra &quot;Click per selezionare&quot; come opzione di default';
// Settings
$hesklang['mms']='Modalità di manutenzione';
$hesklang['mmd']='Attiva modalità di manutenzione';
// Customer notice
$hesklang['mm1']='Maintenance in progress - Manutenzione in corso';
$hesklang['mm2']='Al fine di eseguire operazioni di manutenzione il servizio ticket è temporaneamente sospeso. In order to perform scheduled maintenance, our help desk has shut down temporarily.';
$hesklang['mm3']='Ci scusiamo per il disagio e vi invitiamo a riprovare più tardi. We apologize for the inconvenience and ask that you please try again later.';
// Staff notice
$hesklang['mma1']='Modalità manutenzione è attiva!';
$hesklang['mma2']='I clienti non sono in grado di usare l\'help desk.';
$hesklang['tools']='Strumenti';
$hesklang['banemail']='Email bannate';
$hesklang['banemail_intro']='Impedisci ad alcuni indirizzi email di aprire ticket.';
$hesklang['no_banemails']='<i>Nessuna email risulta al momento bannata.</i>';
$hesklang['eperm']='Ban email permanente:';
$hesklang['bananemail']='Indirizzo email da bannare';
$hesklang['savebanemail']='Banna questa email';
$hesklang['enterbanemail']='Inserire l\'indirizzo email da bannare .';
$hesklang['validbanemail']='Inserire un indirizzo email valido (<i>john.doe@dominio.com</i>) or email domain (<i>@domain.com</i>)';
$hesklang['email_banned']='Questo indirizzo email <i>%s</i> è stato bannato quindi al momento non è possibile accettare ticket da tale email.'; // %s will be replaced with email
$hesklang['emailbanexists']='L\'Email <i>%s</i> risulta già bannata.'; // %s will be replaced with email
$hesklang['email_unbanned']='Ban email cancellato';
$hesklang['banby']='Ban eseguito da';
$hesklang['delban']='Cancella ban';
$hesklang['delban_confirm']='Cancellare questo ban?';
$hesklang['baned_e']='Siete stati bannati dall\'aprire nuovi ticket.';
$hesklang['baned_ip']='Siete stati bannati da questo help desk';
$hesklang['can_ban_emails']='Può bannare gli indirizzi email';
$hesklang['can_unban_emails']='Può cancellare i ban email (abilitare il ban email)';
$hesklang['eisban']='Questo indirizzo email risulta già bannato.';
$hesklang['click_unban']='Click qui per cancellare il ban.';
$hesklang['banip']='IPs Ban';
$hesklang['banip_intro']='Un visitatore proveniente da IP bannato non potrà visualizzare nè inviare ticket e loggarsi nell\'help desk.';
$hesklang['ipperm']='Ban permanente IP:';
$hesklang['iptemp']='Log in non corretti ban:';
$hesklang['savebanip']='Bannare questo IP';
$hesklang['no_banips']='<i>Nessun IP bannato.</i>';
$hesklang['bananip']='IP da bannare';
$hesklang['banex']='Esempi:';
$hesklang['iprange']='Intervallo IP';
$hesklang['savebanip']='Banna questo IP';
$hesklang['ippermban']='Bannare questo IP in modo permanente';
$hesklang['enterbanip']='Inserire indirizzo o indirizzi IP da bannare.';
$hesklang['validbanip']='Inserire uno o più IP validi';
$hesklang['ip_banned']='L\'indirizzo IP <i>%s</i> è stato bannato e l\'help desk non accetterà nuovi ticket.'; // %s will be replaced with ip
$hesklang['ip_rbanned']='L\'intervallo di IP <i>%s</i> sono stati bannati e l\'help desk non accetterà nuovi ticket.'; // %s will be replaced with ip
$hesklang['ipbanexists']='L\'IP <i>%s</i> è già bannato.'; // %s will be replaced with ip
$hesklang['iprbanexists']='L\'intervallo di IP <i>%s</i> è già bannato.'; // %s will be replaced with ip
$hesklang['ip_unbanned']='Ban IP cancellato';
$hesklang['ip_tempun']='Ban temporaneo IP cancellato';
$hesklang['can_ban_ips']='Può bannare gli IP';
$hesklang['can_unban_ips']='Può sbannare gli IP (abilitare ban IP)';
$hesklang['ipisban']='Questo indirizzo IP è bannato.';
$hesklang['m2e']='Scade in (minuti)';
$hesklang['info']='Info';
$hesklang['sm_title']='Messaggi di servizio';
$hesklang['sm_intro']='Visualizzare un messaggio di servizio nell\'area clienti, ad esempio, per notificare loro sui problemi noti e importanti notizie.';
$hesklang['can_service_msg']='Modifica messaggi di servizio';
$hesklang['new_sm']='Nuovo messaggio di servizio';
$hesklang['edit_sm']='Modifica messaggio di servizio';
$hesklang['ex_sm']='Messaggi di servizio esistenti';
$hesklang['sm_author']='Autore';
$hesklang['sm_type']='Tipo';
$hesklang['sm_published']='Pubblicato';
$hesklang['sm_draft']='Salvato';
$hesklang['sm_style']='Stile';
$hesklang['sm_none']='Nessuno';
$hesklang['sm_success']='Successo';
$hesklang['sm_info']='Info';
$hesklang['sm_notice']='Notizia';
$hesklang['sm_error']='Errore';
$hesklang['sm_save']='Salvare messaggio di servizio';
$hesklang['sm_preview']='Anteprima messaggio di servizio';
$hesklang['sm_mtitle']='Titolo';
$hesklang['sm_msg']='Messaggio';
$hesklang['sm_e_title']='Inserire il titolo del messaggio di servizio';
$hesklang['sm_e_msg']='Inserire il messaggio di servizio';
$hesklang['sm_e_id']='ID messaggio non compilato';
$hesklang['sm_added']='Un nuovo messaggio di servizio è stato aggiunto';
$hesklang['sm_deleted']='Messaggio di servizio cancellato';
$hesklang['sm_not_found']='Questo messaggio di servizio non esiste';
$hesklang['no_sm']='Nessun messaggio di servizio';
$hesklang['del_sm']='Cancellare questo messaggio di servizio?';
$hesklang['sm_mdf']='Messaggio di servizio salvato correttamente';
$hesklang['sska']='Mostra articoli suggeriti';
$hesklang['taws']='Questi articoli potrebbero esserti utili:';
$hesklang['defaults']='Defaults';
$hesklang['pncn']='Opzione notifica cliente in nuovo ticket';
$hesklang['pncr']='Opzione notifica cliente in nuova risposta';
$hesklang['pssy']='Vedere quali articoli della knowledgebase sono stati suggeriti al cliente';
$hesklang['ccct']='Permettere ai clienti di risolvere i ticket';
$hesklang['custnot']='Notificare il cliente quando';
$hesklang['notnew']='Un nuovo ticket è stato aperto';
$hesklang['notclo']='Un ticket è stato risolto';
$hesklang['enn']='Eccezione recupero per le tubazioni Email / POP3 se l\'oggetto del messaggio contiene:';
$hesklang['spamn']='Avviso al cliente controlla cartella SPAM';
$hesklang['spam_inbox']='<span style="color:red"><b>Nessuna risposta ricevuta?</b><br />Inviamo sempre una notifica email all\'apertura di un nuovo ticket. Se non ricevete nulla entro alcuni minuti, vi suggeriamo di controllare la cartella SPAM. Rimuovere il messaggio dallo <b>SPAM</b> per evitare problemi di ricezione in futuro.</span>';
$hesklang['s_ekb']='Attiva Knowledgebase';
$hesklang['ekb_n']='<b>NO</b>, disattiva Knowledgebase';
$hesklang['ekb_y']='<b>SI</b>, attiva Knowledgebase';
$hesklang['ekb_o']='<b>SI</b>, usare HESK solo come Knowledgebase(<i>disabilitare ticket help desk</i>)';
$hesklang['kb_set']='Impostazioni Knowledgebase';
$hesklang['kbo1']='Modalità solo Knowledgebase';
$hesklang['kbo2']='<br /><br />Il visitatore non può aprire i ticket e viene portato direttamente alla knowledgebase.';
$hesklang['fpass']='Smarrito la password?';
$hesklang['passr']='Resetta Password';
$hesklang['passa']='Consentire agli utenti di reimpostare una password dimenticata tramite e-mail';
$hesklang['passe']='Inserite il vostro indirizzo email';
$hesklang['passs']='Invia link di reset password';
$hesklang['noace']='Nessun account con questo indirizzo email trovato';
$hesklang['pemls']='Vi abbiamo inviato una mail con le istruzioni su come reimpostare la password';
$hesklang['reset_password']='Reset password per il nostro help desk'; // Email subject
$hesklang['ehash']='Link per il reset della password invalido o scaduto';
$hesklang['ehaip']='Indirizzo IP errato. La password può essere resettata solo dallo stesso IP che ha richiesto il link.';
$hesklang['resim']='<b>Impostate la vostra password nel modulo sottostante!</b>';
$hesklang['permissions']='Permessi';
$hesklang['atype']='Tipo di account';
$hesklang['astaff']='Staff';
$hesklang['oon1']='Inviami solo ticket aperti';
$hesklang['oon2']='Inviami tutti i ticket';
$hesklang['anyown']='Qualsiasi proprietario';
$hesklang['pfr']='Un altro POP3 fetching è al momento in corso.';
$hesklang['pjt']='Task timeout';
$hesklang['pjt2']='minuti dopo la partenza';
$hesklang['nkba']='Knowledgebase richiede articoli unici e diversi per funzionare.<br /><br />Considerate di aggiungere più articoli di knowledgebase per migliorare la risposta alla ricerca.';
$hesklang['saa']='Gli articoli Sticky sono visualizzati all\'inizio della pagina';
$hesklang['yhbr']='Siete stati bloccati fuori per %s minuti per eccesso di risposte inviate al ticket.';
$hesklang['sir']='ReCaptcha V1 API (obsoleto)';
$hesklang['sir2']='ReCaptcha V2 API (raccomandato)';
$hesklang['rcpb']='Site key (Chiave pubblica Public key)';
$hesklang['rcpv']='Secret key (Chiave privata Private key)';

// Language for Google reCaptcha API version 2
// Supported language codes: https://developers.google.com/recaptcha/docs/language
// If your language is NOT in the supported langauges, leave 'en'
$hesklang['RECAPTCHA']='it';


// DO NOT CHANGE BELOW
if (!defined('IN_SCRIPT')) die('PHP syntax OK!');
