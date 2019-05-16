import core as pornhub

search_keywords = ["pussy"]

instance = pornhub.PornHub("186.225.45.146","37179", search_keywords)

for video in instance.getVideos(10,page=2):
	print(video)

for photo_url in instance.getPhotos():
	print(photo_url)
