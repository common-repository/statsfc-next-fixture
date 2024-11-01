/* global statsfc_lang */

var $j = jQuery;

function StatsFC_NextFixture (key) {
  this.referer = '';
  this.key = key;
  this.team = '';
  this.competition = '';
  this.date = '';
  this.timezone = '';
  this.omitErrors = false;
  this.useDefaultCss = false;
  this.lang = 'en';

  this.translate = function (key) {
    if (
      typeof statsfc_lang === 'undefined' ||
      typeof statsfc_lang[key] === 'undefined' ||
      statsfc_lang[key].length === 0
    ) {
      return key;
    }

    return statsfc_lang[key];
  };

  this.display = function (placeholder) {
    this.loadLang('statsfc-lang', this.lang);

    var $placeholder;

    switch (typeof placeholder) {
      case 'string':
        $placeholder = $j('#' + placeholder);
        break;
      case 'object':
        $placeholder = placeholder;
        break;
      default:
        return;
    }

    if ($placeholder.length === 0) {
      return;
    }

    if (this.useDefaultCss === true || this.useDefaultCss === 'true') {
      this.loadCss('statsfc-next-fixture-css');
    }

    if (typeof this.referer !== 'string' || this.referer.length === 0) {
      this.referer = window.location.hostname;
    }

    var $container = $j('<div>').addClass('sfc_nextfixture');

    // Store globals variables here so we can use it later.
    var date = this.date;
    var omitErrors = (this.omitErrors === true || this.omitErrors === 'true');
    var translate = this.translate;

    $j.getJSON(
      'https://widgets.statsfc.com/api/next-fixture.json?callback=?',
      {
        key: this.key,
        domain: this.referer,
        team: this.team,
        competition: this.competition,
        date: this.date,
        timezone: this.timezone,
        lang: this.lang,
      },
      function (data) {
        if (data.error) {
          if (omitErrors) {
            return;
          }

          var $error = $j('<p>').css('text-align', 'center');

          if (data.customer && data.customer.attribution) {
            $error.append(
              $j('<a>').attr({
                href: 'https://statsfc.com',
                title: 'Football widgets and API',
                target: '_blank',
              }).text('Stats FC'),
              ' – ',
            );
          }

          $error.append(translate(data.error));

          $container.append($error);

          return;
        }

        var $status = $j('<span>');

        if (! data.match.started || date.length > 0) {
          $status.append(
            $j('<span>').addClass('sfc_date').text(data.match.date),
            $j('<br>'),
            $j('<span>').addClass('sfc_time').text(data.match.time),
          );
        } else {
          $status.append(
            $j('<span>').html('<small>Live: ' + data.match.status + '</small><br>' + data.match.score[0] + ' - ' + data.match.score[1]),
          );
        }

        var $table = $j('<table>').append(
          $j('<tbody>').append(
            $j('<tr>').append(
              $j('<td>').addClass('sfc_home sfc_badge_' + data.match.homepath).append(
                $j('<img>').attr({
                  src: 'https://cdn.statsfc.com/kit/' + data.match.homeshirt,
                  title: data.match.home,
                  width: 80,
                  height: 80,
                }),
                $j('<br>'),
                $j('<span>').addClass('sfc_team').text(data.match.home),
              ),
              $j('<td>').addClass('sfc_details').append(
                $j('<span>').addClass('sfc_competition').text(data.match.competition),
                $j('<br>'),
                $status,
              ),
              $j('<td>').addClass('sfc_away sfc_badge_' + data.match.awaypath).append(
                $j('<img>').attr({
                  src: 'https://cdn.statsfc.com/kit/' + data.match.awayshirt,
                  title: data.match.away,
                  width: 80,
                  height: 80,
                }),
                $j('<br>'),
                $j('<span>').addClass('sfc_team').text(data.match.away),
              ),
            ),
          ),
        );

        $container.append($table);

        if (data.customer.attribution) {
          $container.append(
            $j('<div>').attr('class', 'sfc_footer').append(
              $j('<p>').append(
                $j('<small>').append('Powered by ').append(
                  $j('<a>').attr({
                    href: 'https://statsfc.com',
                    title: 'StatsFC – Football widgets',
                    target: '_blank',
                  }).text('StatsFC.com'),
                ),
              ),
            ),
          );
        }
      },
    );

    $placeholder.append($container);
  };

  this.loadCss = function (id) {
    if (document.getElementById(id)) {
      return;
    }

    var css, fcss = (document.getElementsByTagName('link')[0] || document.getElementsByTagName('script')[0]);

    css = document.createElement('link');
    css.id = id;
    css.rel = 'stylesheet';
    css.href = 'https://cdn.statsfc.com/css/next-fixture.css';

    fcss.parentNode.insertBefore(css, fcss);
  };

  this.loadLang = function (id, l) {
    if (document.getElementById(id)) {
      return;
    }

    var lang, flang = document.getElementsByTagName('script')[0];

    lang = document.createElement('script');
    lang.id = id;
    lang.src = 'https://cdn.statsfc.com/js/lang/' + l + '.js';

    flang.parentNode.insertBefore(lang, flang);
  };
}

/**
 * Load widgets dynamically using data-* attributes
 */
$j('div.statsfc-next-fixture').each(function () {
  var key = $j(this).attr('data-key'),
    nextFixture = new StatsFC_NextFixture(key),
    data = $j(this).data();

  for (var i in data) {
    nextFixture[i] = data[i];
  }

  nextFixture.display($j(this));
});
