const codeName = document.createTextNode(navigator.appCodeName);
document.getElementById('codeName').appendChild(codeName);

const appName = document.createTextNode(navigator.appName);
document.getElementById('appName').appendChild(appName);

const appVersion = document.createTextNode(navigator.appVersion);
document.getElementById('appVersion').appendChild(appVersion);

const userAgent = document.createTextNode(navigator.userAgent);
document.getElementById('userAgent').appendChild(userAgent);

const vendor = document.createTextNode(navigator.vendor);
document.getElementById('vendor').appendChild(vendor);

const language = document.createTextNode(navigator.language);
document.getElementById('language').appendChild(language);

const platform = document.createTextNode(navigator.platform);
document.getElementById('platform').appendChild(platform);

const hardwareConcurrency = document.createTextNode(navigator.hardwareConcurrency);
document.getElementById('hardwareConcurrency').appendChild(hardwareConcurrency);

const deviceMemory = document.createTextNode(navigator.deviceMemory);
document.getElementById('deviceMemory').appendChild(deviceMemory);

const online = document.createTextNode(navigator.online);
document.getElementById('online').appendChild(online);

const cookieEnabled = document.createTextNode(navigator.cookieEnabled);
document.getElementById('cookieEnabled').appendChild(cookieEnabled);

const doNotTrack = document.createTextNode(navigator.doNotTrack);
document.getElementById('doNotTrack').appendChild(doNotTrack);
