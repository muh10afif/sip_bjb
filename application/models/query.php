-- mencari tiap kanwil
SELECT segmen, COUNT(d.segmen) as jumlah
FROM tr_kelolaan as k
left JOIN m_debitur as d ON d.deal_reff = k.deal_reff
WHERE d.kanwil = 'Kanwil 1' and jenis_debitur = 'npl'
GROUP BY segmen

-- mencari tiap cabang
SELECT cabang_induk, segmen, COUNT(d.cabang_induk) as jumlah
FROM tr_kelolaan as k
left JOIN m_debitur as d ON d.deal_reff = k.deal_reff
WHERE d.kanwil = 'Kanwil 1' and jenis_debitur = 'npl'
GROUP BY cabang_induk, segmen

-- mencari tiap ao
SELECT name, segmen, COUNT(d.segmen)
FROM m_employee as e
left JOIN tr_kelolaan as k ON k.reg_employee = e.reg_employee
left JOIN m_debitur as d ON d.deal_reff = k.deal_reff
WHERE d.kanwil = 'Kanwil 1' and jenis_debitur = 'npl'
GROUP BY name, segmen
ORDER BY name asc

-- mencari kolektibilitas tiap ao
SELECT name,b.kolektibilitas,  segmen,  COUNT(d.segmen), d.cabang_induk
FROM m_employee as e
left JOIN tr_kelolaan as k ON k.reg_employee = e.reg_employee
left JOIN m_debitur as d ON d.deal_reff = k.deal_reff
left JOIN m_kolektibilitas as b ON b.id = d.kolektibilitas
WHERE d.kanwil = 'Kanwil 1' and jenis_debitur = 'npl'
GROUP BY name, segmen, d.kolektibilitas
ORDER BY name asc
