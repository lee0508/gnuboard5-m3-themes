// 테마에서 쓰는 Boxicons(v2 이름) → v3 모양을 CSS mask 로 그리는 로컬 아이콘 CSS 생성기
// 사용: npm pack @iconify-json/boxicons@1.2.0 와 @iconify-json/bx@1.2.3 을 각각 풀고
//   BX3=<v3 풀린 폴더> BX2=<v2 풀린 폴더> node tools/build-boxicons.cjs css/icons/boxicons-local.css bx-이름 ...
const fs = require('fs');
const [,, outPath, ...names] = process.argv;
const v3 = require(process.env.BX3 + '/package/icons.json');
const v2 = require(process.env.BX2 + '/package/icons.json');
// v2 이름 → [세트, v3(또는 v2 로고) 이름]. v3 에 없는 브랜드 로고만 v2 세트에서 가져온다.
const MAP = {
  'bx-chat':['v3','message-dots'], 'bx-chevron-left':['v3','chevron-left'], 'bx-chevron-right':['v3','chevron-right'],
  'bx-credit-card':['v3','credit-card'], 'bx-edit':['v3','edit'], 'bx-group':['v3','group'], 'bx-help-circle':['v3','help-circle'],
  'bx-history':['v3','history'], 'bx-line-chart':['v3','line-chart-square'], 'bx-log-in':['v3','arrow-in-right-square-half'],
  'bx-log-out':['v3','arrow-out-right-square-half'], 'bx-question-mark':['v3','help-circle'], 'bx-right-arrow-alt':['v3','arrow-right-stroke'],
  'bx-up-arrow-alt':['v3','arrow-up-stroke'], 'bx-star':['v3','star'], 'bx-trending-up':['v3','trending-up'], 'bx-user-plus':['v3','user-plus'],
  'bx-user':['v3','user'], 'bx-body':['v3','body'], 'bx-tooth':['v3','tooth'], 'bx-building-house':['v3','building-house'],
  'bx-calendar-check':['v3','calendar-check'], 'bx-check-circle':['v3','check-circle'], 'bx-check-shield':['v3','check-shield'],
  'bx-conversation':['v3','message-bubble-dots'], 'bx-face':['v3','face'], 'bx-heart':['v3','heart'], 'bx-info-circle':['v3','info-circle'],
  'bx-loader-circle':['v3','loader-dots'], 'bx-map':['v3','map'], 'bx-menu':['v3','menu'], 'bx-x':['v3','x'],
  'bx-message-rounded-dots':['v3','message-circle-dots'], 'bx-phone':['v3','phone'], 'bx-phone-call':['v3','phone-ring'],
  'bx-plus-medical':['v3','plus-big-filled'], 'bx-calendar':['v3','calendar'], 'bx-calendar-x':['v3','calendar-x'], 'bx-lock-alt':['v3','lock'],
  'bx-save':['v3','save'], 'bx-search-alt-2':['v3','search'], 'bx-user-voice':['v3','user-voice'], 'bx-x-circle':['v3','x-circle'], 'bx-pulse':['v3','pulse'], 'bx-time-five':['v3','clock'],
  'bxs-color':['v3','palette-filled'], 'bxs-coupon':['v3','ticket-filled'], 'bxs-diamond':['v3','diamond-filled'], 'bxs-gift':['v3','gift-filled'],
  'bxs-hot':['v3','hot-filled'], 'bxs-like':['v3','like-filled'], 'bxs-megaphone':['v3','megaphone-filled'], 'bxs-phone-call':['v3','phone-ring-filled'],
  'bxs-shopping-bag':['v3','shopping-bag-filled'], 'bxs-star':['v3','star-filled'], 'bxs-user-circle':['v3','user-circle-filled'],
  'bxl-facebook':['v2','bxl-facebook'], 'bxl-instagram':['v2','bxl-instagram'], 'bxl-twitter':['v2','bxl-twitter'],
  'bxl-kakao-talk':['v3','message-filled'], // 카카오톡 로고는 Boxicons v3·iconify v2 세트에 없어 말풍선으로 대신함
};
const svg = (set, n) => {
  const src = set === 'v3' ? v3 : v2;
  const ic = src.icons[n];
  if (!ic) throw new Error(`없는 아이콘: ${set}/${n}`);
  const w = ic.width || src.width || 24, h = ic.height || src.height || 24;
  return `<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 ${w} ${h}'>${ic.body.replace(/"/g, "'")}</svg>`;
};
const uri = s => `url("data:image/svg+xml,${encodeURIComponent(s).replace(/%20/g,' ').replace(/%3D/g,'=').replace(/%3A/g,':').replace(/%2F/g,'/').replace(/%27/g,"'")}")`;
const rows = names.sort().map(name => {
  if (!MAP[name]) throw new Error(`대응표에 없는 이름: ${name}`);
  const [set, n] = MAP[name];
  return `.${name}{--bx-icon:${uri(svg(set, n))}} /* ${set === 'v3' ? 'v3 ' : 'v2 로고 '}${n} */`;
});
const head = `/* 테마 아이콘: Boxicons v3 (MIT, github.com/box-icons/boxicons-core, npm @iconify-json/boxicons 1.2.0) 를 로컬에서 그린다.
   마크업은 그누보드에 익숙한 v2 클래스 이름(<i class="bx bx-이름">)을 그대로 쓰고, 모양만 v3 로 바꾼다(줄 끝 주석이 v3 이름).
   브랜드 로고(bxl-*)는 v3 에 없어 Boxicons v2.1.4 (MIT, npm @iconify-json/bx) 에서 가져온다.
   외부 CDN 을 쓰지 않는다 (공통 디자인 규칙 5장). 새 아이콘은 tools/build-boxicons.cjs 대응표에 더하고 다시 생성한다. */
.bx,.bxs,.bxl{display:inline-block;width:1em;height:1em;flex:none;vertical-align:-.125em;background-color:currentColor;
  -webkit-mask:var(--bx-icon) center/contain no-repeat;mask:var(--bx-icon) center/contain no-repeat}
`;
fs.writeFileSync(outPath, head + rows.join('\n') + '\n');
console.log(outPath, rows.length, 'icons');
