import __init__ as pornhub

search_keywords = ["test"]

client = pornhub.PornHub(search_keywords)

for video in client.getVideos(10,page=1):
	print(video)

for photo_url in client.getPhotos():
	print(photo_url)
