<?php

namespace Database\Seeders;

use App\Helpers\SeederHelper;
use Illuminate\Database\Seeder;

class LongTermMemorySeeder extends Seeder
{
    private array $memories = [
        'Podstawową jednostką organizacyjną w ZentiIT są autonomiczne zespoły. Każdy zespół w firmie jest autonomiczny niezależnie od tego, czy ma kierownika, czy jest samozarządzający. Członkowie zespołów mają prawo podejmować decyzje dotyczące własnego zespołu i mające na niego wpływ. Granice autonomii wyznacza ogólnie pojęte dobro firmy oraz wspólnie ustalone cele firmowe, które pokazują kierunek działania i oczekiwania ogólnofirmowe. Zespoły nie są samodzielnymi bytami, lecz działają wspólnie.',
        'Zespoły nie są samodzielnymi bytami, lecz działają wspólnie. To znaczy, że w swoim obrębie są autonomiczne, jednak współpracują ze sobą i wspólnie dążą do realizacji celów całej firmy. Cel firmowy jest nadrzędny nad celami poszczególnych zespołów. Jednak to nie znaczy, że decyzje są podejmowane odgórnie. Stawiamy na interdyscyplinarne i samoorganizujące się zespoły. Zdajemy sobie sprawę, że podejmowanie decyzji bezpośrednio w w zespole skraca proces decyzyjny i często prowadzi do wybrania lepszego rozwiązania. Stawiając na autonomiczne zespoły, oddelegowaliśmy do nich znaczny zakres decyzyjności, jednocześnie zapewniając wsparcie oraz dostarczając wszelkich niezbędnych informacji, których zespół potrzebuje do podejmowania samodzielnych decyzji.',
        'Autonomiczne zespoły są dla nas ważne, ale cały czas pamiętamy, że jesteśmy jedną firmą. Wspieramy się wzajemnie, wymieniamy się wiedzą i doświadczeniem, wspólnie podejmujemy wyzwania. Dbamy, żeby pomiędzy zespołami nie było zbyt dużych różnic w wynagrodzeniach, mamy wspólne budżety, które nie są uzależnione od wyników poszczególnych zespołów, a raczej powiązane z wynikiem całej firmy. Jeżeli w jakimś zespole występują problemy to nie zostawiamy go samemu sobie. W sytuacjach trudnych wspólnie szukamy rozwiązań.',
        'W ZenteIT stawiamy na współodpowiedzialność. Rozumiemy to jako branie odpowiedzialności za realizację zadań własnych, zespołu oraz całej firmy. Nie unikamy odpowiedzialności, nie spychamy jej na inne osoby. Jesteśmy gotowi na wyzwania. Czujemy się odpowiedzialni za biznes naszych klientów.',
        'Nasze firmowe cele ustalamy w formie Kluczowych Rezultatów.
Na każdy nowy rok wspólnie zastanawiamy się, co jest dla nas ważne i jak zdefiniować rezultaty, które razem chcemy uzyskać. Kluczowe Rezultaty stają się takim drogowskazem dla poszczególnych zespołów i sprawiają, że zespoły pracują nad osiągnięciem celów całej firmy.',
        'Liczba Kluczowych Rezultatów na dany rok waha się od trzech do czterech. Z jednej strony to ważne, abyśmy mogli utrzymać prostotę i łatwo zapamiętać te cele. Z drugiej strony nie chcemy ich uprościć za bardzo, żeby realizując jeden z celów firmy nie zapominać o innych ważnych obszarach naszej działalności. Rozwiązaniem jest mały zestaw wzajemnie kontrolujących i wspierających się zdefiniowanych rezultatów.',
        'Dla celów (kluczowych rezultatów) ustalamy mierniki, dzięki którym możemy śledzić ich realizację i wiedzieć, czy osiągamy oczekiwane rezultaty. Poziomy mierników są ustalane wspólnie przez wszystkie zespoły. Część z nich jest planowana na poziomie całej firmy w odniesieniu do wcześniej osiągniętych poziomów lub zewnętrznych punktów odniesienia (raportów rynkowych, wyników finansowych innych firm czy całych branż), a część jest planowana na poziomie zespołów i cel firmowy “wychodzi” z ich sumy.',
        '1. Każdy zespół w ZentiIT jest wspierany przez osobę spoza zespołu (opiekuna). Najczęściej jest to osoba z Zespołu Zarządzającego, ale może to być też inna osoba, która potrafi realnie wesprzeć zespół na różnych płaszczyznach jego działania.
Osoba taka najczęściej wspiera zespół w następujących obszarach:
kontakt z osobami zarządzającymi u naszych klientów - pomoc w rozwiązywaniu konfliktów, rozwiązywanie eskalacji, budowanie relacji,
wsparcie merytoryczne,
konsultacje podejmowanych decyzji,
wsparcie w planowaniu strategicznym,
w sytuacji, gdy zespół samodzielnie nie potrafi osiągać zakładanych rezultatów, jest to pierwsza osoba, z którą członkowie zespołu próbują rozwiązać problem. W takich sytuacjach ma ona również wpływ na wszelkie decyzje podejmowane w zespole.',
        'Wspólna praca nad celami firmy sprawia, że każdy z zespołów czuje się współodpowiedzialny za ich osiągnięcie i odpowiada za realizację swojej części celów przed innymi zespołami. Jeśli zespół ma problemy z realizacją swojej części, powinien przedstawić opiekunowi i gronu reprezentantów wyjaśnienie oraz plan działań mających na celu poprawę sytuacji. W takim przypadku ważna jest komunikacja z resztą firmy – z jednej strony, by pokazać plan na poprawę rezultatów, z drugiej strony by móc uzyskać poradę lub wsparcie.',
        'Jeśli zespół nie realizuje zaplanowanych rezultatów i nie widać perspektyw ich poprawy, może nastąpić zewnętrzna ingerencja, być może nawet naruszająca autonomię zespołu. Prawo do takiej ingerencji ma osoba z Zespołu Zarządzającego lub osoba przez niego wyznaczona. O ingerencji są informowani Reprezentanci zespołów. Zewnętrzna ingerencja ma na celu pomóc postawić w zespole ważne pytania i zmotywować do zastanowienia się nad nimi i pracy nad poprawą rezultatów. W przypadku gdy powyższe działania nie przynoszą rezultatów, ostatecznym efektem ingerencji może być nawet rozwiązanie zespołu. Decyzję w tej sprawie podejmuje Zespół Zarządzający.',
        'Aby wspólnie pracować nad ustalonymi celami, promujemy w firmie transparentność. Dostęp do informacji pozwala nam wszystkim mieć świadomość celów, aktualnej sytuacji i pojawiających się wyzwań. Mierzenie osiąganych efektów i ich śledzenie dostarcza nam informacji, na jakim etapie jesteśmy z realizacją naszych celów i czy działania, które podejmujemy, są skuteczne. Jednym z elementów tej transparentności jest Tablica Wyników. Znajdują się w niej wyniki i plany odnośnie wszystkich Kluczowych Rezultatów dotyczących całej firmy i poszczególnych zespołów.',
        'Abyśmy faktycznie byli takim “zespołem zespołów” mamy praktyki, które sprawiają, że efektywnie ze sobą współpracujemy. Do synchronizacji informacji pomiędzy zespołami i podejmowania decyzji, do których potrzebna jest cała organizacja, służą nam cykliczne Spotkania Reprezentantów Zespołów. Jest to jeden z najważniejszych organów decyzyjnych w firmie. Spotkanie to odbywa się cyklicznie i obowiązkowo uczestniczą w nich reprezentanci wszystkich zespołów. Drugie cykliczne spotkanie poświęcone jest podsumowaniu zamkniętego miesiąca i omówieniu najbliższych planów. Na tym spotkaniu również obowiązkowa jest obecność reprezentantów z każdego zespołu firmy.',
        'Oprócz stałych zespołów posiadamy w ZentiIT grupy robocze składające się z chętnych osób z całej firmy, które wspólnie pracują nad wybranymi obszarami działania naszej organizacji. Nazywamy je kręgami, są to na przykład Krąg ds. Integracji, Krąg ds. Rozwoju, Krąg ds. NPS itp. Kręgi również podejmują autonomiczne decyzje w ramach swojego zakresu działania zdefiniowanego przez firmę.',
        'Jak się zalogować na Legimi?
Każdy pracownik posiada swój unikalny kod dostępu, który aktywuje pakiet na stronie: https://www.legimi.pl/ZentiIT.
Osoby, które dołączają do ZentiIT po 1 czerwca 2023, otrzymują kody w indywidualnej wiadomości pierwszego dnia pracy.
W celu korzystania z benefitu należy pobrać aplikację Legimi, założyć konto lub wykorzystać firmowy kod na koncie, które już się posiada i od tego momentu można korzystać z biblioteki na aż 4 wybranych przez siebie urządzeniach ?',
        'W przypadku Legimi proszę się zgłaszać do W przypadku pytań: Karoliny Zentowskiej?',
        'W ZentiIT istnieje możliwość uczestnictwa w bezpłatnych zajęciach grupowych (grupy liczące do 6 osób). Zajęcia odbywają się raz w tygodniu w trybie zdalnym i trwają 75 minut.
Zajęcia z języka angielskiego',
        'W ZentiIT ważne jest dla nas dbanie nie tylko o rozwój zawodowy i satysfakcję z pracy, ale również o komfort i dobrostan psychiczny. Współpracujemy z Wellbee – platformą zrzeszającą wielu specjalistów z zakresu pomocy psychologicznej, dzięki której można umawiać się na spotkania. przycholog',
        'Korzystanie z platformy jest anonimowe, a ZentiIT otrzymuje tylko zbiorcze statystyki dotyczące ogólnej ilości wizyt. Każdy może czuć się swobodnie i bezpiecznie.
W ramach współpracy każdy pracownik (na Wellbee) ma 110 zł zniżki na pierwszą wizytę oraz 30 zł zniżki na każdą kolejną.',
        'Głównym drogowskazem dla działań rozwojowych są Kluczowe Rezultaty realizowane przez firmę i przez nasze zespoły każdego dnia. Wspólnie odpowiadamy za odkrywanie dróg prowadzących do założonych celów, dlatego tak ważne staje się szukanie inspiracji, aby znajdować miejsca, o których nawet nie wiemy, że istnieją. 4 stopnie poznania pozwolą nam uświadomić sobie co wiemy, co umiemy, z czego korzystamy, a czego musimy jeszcze się nauczyć, aby pełniej realizować założone cele.',
        'Chcemy wykorzystywać potencjał różnorodnych form rozwoju. Warto czerpać z doświadczenia innych. Wystarczy znaleźć w firmie mentora, coacha czy zainteresować się wspólnym programowaniem. A może chcesz zobaczyć jak pracuje się w innych zespołach? Porozmawiać o swojej stałej lub tymczasowej zmianie roli lub zespołu. Bogactwo informacji zawarte jest w książkach, czasopismach, artykułach w internecie. Również biblioteka firmowa pełna jest wartościowych książek. Warto zapoznać się z jej zbiorami, a gdy zechcesz zamówić nową pozycję skorzystaj z procesu doradczego. Nie zapomnij o prenumeracie "Programisty":) Korzystaj i rekomenduj nagrania z wywiadów, konferencji.',
        'Zespołowe budżety rozwojowe ustalane są na początku każdego roku przez grupę ds. rozwoju i są wyliczane jako konkretna kwota na osobę pomnożona przez liczbę osób w zespole zgodnie ze stanem zatrudnienia na 1 stycznia danego roku. Budżet na zespół nie zwiększa się w związku z zatrudnianiem nowych osób w ciągu roku.',
        'Jak korzystać z budżetu rozwojowego. Każdy z Was, może przeznaczyć swoją kwotę indywidualną na szkolenia, konferencje, kursy, jak i wszelkie inne możliwe wydarzenia związane z rozwojem i powiązane z pełnioną rolą/stanowiskiem/obraną ścieżką rozwoju w ZentiIT w celu podnoszenia kompetencji.
Jeśli jesteście zainteresowani daną formą rozwoju, przed zakupem skonsultujcie się z osobą odpowiedzialną za zespół lub z całym zespołem. Porozmawiajcie w jaki sposób przekażecie i wykorzystacie wiedzę w zespole. Jeżeli ktoś jest przeciw to próbujemy wymieniać się argumentami w celu znalezienia konsensusu. Warto zajrzeć do zrealizowanych szkoleń zewnętrznych i sprawdzić, czy jakieś szkolenie ma polecenia od innych osób.',
        'Dobrą praktyką jest planowanie wykorzystania budżetu w zespole np.: podczas omawiania PzW tak aby uzupełniać kompetencje zespołowe czy wymieniać/uzupełniać się niewykorzystanym indywidualnym budżetem. Warto planować szkolenia już na początku roku ;) Pamiętajcie również, że spotkania 1-1 służą temu, aby omawiać potrzeby i oczekiwania w zakresie rozwoju.',
        'Dobrą praktyką jest planowanie wykorzystania budżetu w zespole np.: podczas omawiania PzW tak aby uzupełniać kompetencje zespołowe czy wymieniać/uzupełniać się niewykorzystanym indywidualnym budżetem. Warto planować szkolenia już na początku roku ;) Pamiętajcie również, że spotkania 1-1 służą temu, aby omawiać potrzeby i oczekiwania w zakresie rozwoju.
W przypadku, gdy wybrane szkolenie/konferencja/szkoła przekracza indywidualną kwotę z budżetu zespołowego możecie rozważyć opcję współfinansowania. Tą część “ponad” możecie zapłacić sami a na tą część “Zentową” wziąć fakturę. Oczywiście możecie również w uzgodnieniu z zespołem i kierownikiem rozważyć wyższą indywidualna kwotę ale tak aby zmieścić się całościowo w budżecie zespołowym.
Jeśli zastanawiacie się nadal jak skorzystać z budżetu skontaktujcie się ze swoim HR Biznes Partnerem lub po prostu HRem.',
        'Swoją wiedzę możesz też poszerzać poprzez szkolenia wewnętrzne. Zapoznaj się z obecnie realizowanymi szkoleniami w firmie. W zakładce Giełda- możesz znaleźć ciekawe rzeczy, które wychodzą spod rąk Naszych kolegów. Poszukaj osób, które byłyby zainteresowane tym tematem co Ty i razem znajdźcie w firmie kogoś, kto może was przeszkolić. Jeśli nie będzie tej wiedzy w ZentiIT, zajrzyj do ITCornera, zrzeszającego 60 firm, czyli w sumie 1300 pracowników, prawdopodobieństwo znalezienia tego czego szukasz zwiększa się:) Zapytaj koordynatorów ITCorner w ZentiIT jak sprawdzić, o kogo pytać. Szkolenia zewnętrzne komercyjne również podnoszą kompetencje. Aby wybrać się na ciekawe wydarzenie, przejdź do FAQ, z którego dowiesz się, co zrobić ze swoją potrzebą szkoleniową. Możesz również skorzystać ze ściągawki czyli kroków procesu doradczego.',
        'ZASADY OBOWIĄZUJĄCE W KUCHNI
1. Myjemy po sobie naczynia.
2. Gdy pobrudzimy blat – wycieramy go.
3. Pilnujmy swoich produktów w lodówce – warto zerknąć na termin ważności i zdatność do spożycia.
4. Podpisujemy swoje produkty w lodówce.
5. Mniej więcej co miesiąc/półtorej miesiąca (zawsze w piątek) są sprzątane nasze lodówki - informacja pojawia się na worplace dwa dni wcześniej. Obok lodówek pojawia się skrzynka, do której należy włożyć rzeczy, które mają w niej zostać - reszta zostanie wyrzucona (łącznie z pojemnikami!), co nie znaczy, że jeśli czegoś nie chcemy przechować to zostawiamy to w lodówce! Takie jedzenie należy po prostu samemu wyrzucić.
6. Zanim otworzymy kolejny karton mleka, upewniamy się, że nie ma poprzedniego w lodówce.
7. Gdy otwieramy nowy karton mleka opisujemy go datą otwarcia.
8. Gdy kończy się kawa w ekspresie to uzupełniamy braki.
9. Herbata, kawa, cukier, mleko są wspólne.
10. Nie wynosimy herbat do swojego pokoju.
11. Puste kartony po herbacie/mleku/kawie wyrzucamy.
12. Jeśli w szafce znajdujemy ciasteczka – pamiętamy – jeśli nie Ty je przyniosłeś, to nie są Twoje.
13. Zabieramy swoje pojemniki do domu.
14. Jeśli widzimy, że kończy się kawa/woda/cukier/mleko w kuchni to należy to zgłosić do ADM.',
        'Jak zauważyłeś/łaś dokument stanowi jedną całość, a uszczegółowienie danego tematu kryje się pod linkami, do których w każdej chwili możesz się odnieść. Jeśli masz pytania lub sugestie odnośnie do rozwoju w ZentiIT, zgłoś do reprezentantów kręgu ds. rozwoju.',
        'Aby uniknąć zbędnego ruchu na parkingu, przed wjazdem na parking należy zarezerwować miejsce parkingowe przez stronę internetową: https://parkingo.ZentiIT.pl
Konieczność dokonywania rezerwacji dotyczy wszystkich pracowników, w tym również pracowników przyjeżdżających do biura we Wrocławiu z Poznania, Rzeszowa.
Jeżeli nie otrzymamy z niej numeru miejsca parkingowego nie wjeżdżamy za szlaban. Rezerwację należy wykonać nie wcześniej niż kiedy będziemy widzieć budynek Penta Forum (na światłach przy skrzyżowaniu Legnickiej z Niećwiecią lub przy wjeździe na ulicę Biazowieską) za wyjątkiem rezerwacji dla klientów, których można dokonać wcześniej (należy wtedy zamieścić post na Workplace o takiej rezerwacji)',
        'odwołanie rezerwacji parkingu. Dotyczy wszystkich pracowników, w tym również pracowników przyjeżdżających do biura we Wrocławiu z Poznania, Rzeszowa.
Przy wyjeździe z parkingu do godziny 15.00 każdorazowo odwołujemy rezerwację, za wyjątkiem wyjazdów na zakupy (HR, ADM) oraz dot. obsługi samochodów służbowych bez opiekunów (wyjazd do serwisu, wymiana opon). Zasada obowiązuje również osoby pobierające samochody służbowe na wyjazd w delegację.',
        '4. Mapka parkingu
Mapka dostępna jest tutaj: www.mapka.parkin.com
❗️Za niezastosowanie się do powyższej instrukcji parkingu będzie odbierana karta.
❗️W przypadku stwierdzenia przez administrację budynku, że blokujemy parking przez wjeżdżanie i szukanie wolnych miejsc, wszystkie karty parkingowe zostaną zablokowane.',
        'Hasło do wifi
wifi dla stacji roboczych
SSID: ZentiIT-ng
hasło: otrzymasz od Specjalisty wsparcia IT lub swojego kierownika
Dostępne jest także na stronie info.ZentiIT.pl po zalogowaniu służbowym kontem Google.',
        'W ZentiIT działa system kafeteryjny. Każdy pracownik od początku zatrudnienia dysponuje określoną kwotą, którą może przeznaczyć na wybrane świadczenia. Jednocześnie pracownik nie jest ograniczony tą kwotą, to znaczy może do niej dopłacić, by skorzystać np. z droższego pakietu opieki medycznej czy karty sportowej dla osoby towarzyszącej.
Aby korzystać z systemu kafeteryjnego należy wypełnić oświadczenie: Oświadczenie - system kafeteryjny',
        'Kwoty, którymi dysponuje pracownik w ramach systemu kafeteryjnego (przemnożone przez wymiar zatrudnienia):
155 zł dla pracownika od początku zatrudnienia
225 zł dla pracownika po przepracowanym roku (od daty zatrudnienia)
375 zł dla osób z 3-letnim stażem, które nie są opiekunami samochodu służbowego (czyli nie korzystają z samochodu służbowego w celach prywatnych).
kwota system kafeteryjny',
        'Dofinansowanie do świadczeń przysługuje pracownikom, którzy realnie pracują w danym miesiącu, ewentualnie są na nieobecności za którą przysługuje wynagrodzenie od pracodawcy (urlopy, wynagrodzenie chorobowe) przez co najmniej połowę miesiąca (w dniach roboczych).
Nie przysługują pracownikom, którzy przez większą część danego miesiąca są na zasiłku np. chorobowym, macierzyńskim; urlopie ojcowskim, opiece na dziecko, urlopie wychowawczym, bezpłatnym itd. (do 33 dni choroby w roku jest wynagrodzenie chorobowe, po tym okresie jest to już okres zasiłkowy).W przypadku gdy pracownikowi dodatek na świadczenia za dany miesiąc nie przysługuje, nie musi on ze świadczenia rezygnować, w takim przypadku pokrywa on 100% jego kosztu samodzielnie.
',
        'Zgodnie z przepisami, koszt systemu kafeteryjnego finansowany przez pracodawcę (3 progi -115 zł, 225 zł, 375 zł) stanowi przychód w myśl ustawy o podatku dochodowym od osób fizycznych, a co za tym idzie podlega opodatkowaniu oraz oskładkowaniu, tj. jest doliczany do kwoty brutto wynagrodzenia (stanowiącego podstawę składek społecznych). Następnie kwota ta (115 zł, 225 zł, 375 zł) zostaje potrącona z pensji netto. Wysokość benefitu jest proporcjonalna do wymiaru etatu.',
        'Świadczenia są tylko dla pracowników i ewentualnie ich rodzin (partnerów) i nie mogą być odsprzedawane. W szczególności opcje z symbolem gwiazdki są dostępne dla rodziny lub partnera.',
        'Lista dodatkowych benefitów/świadczeń: MyBenefit, Karta Multisport, LuxMed',
        'Motto firmy ZenteIt: System ERP dopasowany do potrzeb Twojej firmy',
        'O firmie ZenteIt w 2000 roku założyliśmy jako grupa przyjaciół, pasjonatów technologii informatycznych, w składzie: Jan Kowalski,  Jan Kowalski,  Jan Kowalski i Jan Kowalski. Na początku działalności o tworzeniu systemów myśleliśmy tak, jak wszyscy – najlepszy system ERP? Taki, który oferuje jak najwięcej funkcji.',
        'Szybko jednak zmieniliśmy nasze podejście. Obserwując dynamicznie rozwijające się firmy naszych Klientów odkryliśmy, że to nie funkcje systemu są najważniejsze. Zrozumieliśmy, że liderzy poszukują rozwiązań, które pozwolą na obsługę ich unikalnego modelu biznesowego i zapewniają nieograniczone możliwości rozwoju. Postanowiliśmy stworzyć jedną platformę informatyczną, która pozwoli na obsługę wszystkich procesów biznesowych i zapewni środowisko do tworzenia dedykowanych rozwiązań umożliwiających budowanie przewagi na szybko zmieniającym się rynku. Tak powstała platforma Deneum.',
        'ZenteIt obecnie to ponad 200 osób – konsultantów i specjalistów. Siedziba firmy znajduje się we Wrocławiu, natomiast oddziały w Poznaniu, Rzeszowie i Starachowicach. 22 lata doświadczenia to ponad 120 zrealizowanych projektów wdrożeniowych, w których wspieraliśmy wzrost efektywności i rozwój w firmach w całej Polsce. Nie zwalniamy tempa – liczba zrealizowanych projektów stale rośnie.',
        'ystem dla firm handlowych musi być perfekcyjnie dopasowanym narzędziem, wspierającym działania biznesowe, pozwalającym rozwijać skrzydła i trwale podnosić przewagę konkurencyjną. Takim narzędziem jest system Teneum X.',
        ];
    public function run()
    {
        foreach ($this->memories as $memory){
            if($memory !== null){
                SeederHelper::saveLongTermMemory($memory, 1);
            }

        }
    }
}
