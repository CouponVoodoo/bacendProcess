cd C:\Python27\project\couponCrawl\couponsBybrand
REN cbbnew.json cbbold.json
del cbbnew.json
scrapy crawl cbb -o cbbnew.json -t json

