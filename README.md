# PeformanceTests
A plugin to test Server->getPlayerExact() vs Map&lt;username, Player> performance


# Timings with Server->getPlayerExact()
- https://timings.pmmp.io/?id=183047
- https://timings.pmmp.io/?id=183048
- https://timings.pmmp.io/?id=183049

# Timings with Map<username, Player>
- https://timings.pmmp.io/?id=183050
- https://timings.pmmp.io/?id=183051
- https://timings.pmmp.io/?id=183052

# Testing proccess 
I used FakePlayer (https://github.com/Muqsit/FakePlayer) to spawn in 100 fake players that don't move or do anything
Once all the players joined the server I ran /performance main for testing Map<username, Player> performance
Once I got the timings I restarted the server everytime
To test the Server->getPlayerExact() performance I ran /performance server

# Conclusion
Map<username, Player> is about 10 times faster than Server->getPlayerExact() with 100 players on the server.
